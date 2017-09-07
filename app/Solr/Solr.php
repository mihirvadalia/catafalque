<?php

namespace App\Solr;

/**
 * Helper functions for Solr
 * Class Solr
 * @package App\Traits
 */
class Solr {

    // Solr Client
    protected $client;

    // Solr Base URI
    protected $baseUri;

    // Solr query Instance
    protected $selectQuery;

    // Solr Select Query Configuration
    protected $selectConfig;

    /**
     * @param $request
     * @param $config
     * @return array|mixed
     */
    public function select($request, $config)
    {
        $this->selectConfig = $config;

        $this->selectQuery = $this->client->createSelect();

        // facets component
        $this->_set_facets_filters($request);

        // search component
        $this->_set_search_filter($request);

        // basic filters
        $this->_set_basic_filters($request);

        if (isset($this->selectConfig['fields']) && is_array($this->selectConfig['fields']) && count($this->selectConfig['fields']) > 0) {
            // set fields
            $this->_set_select_fields($this->selectConfig['fields']);
        }

        $firstIndex = isset($request['start']) ? $request['start'] : 0;
        $maxResult = isset($request['length']) ? $request['length'] : env('PAGINATION_MAX_ROWS');
        // Limit result set
        if (isset($this->selectConfig['paging']) && $this->selectConfig['paging'] == false) {
            $this->_set_limits(0, 2147483647);
        } else {
            $this->_set_limits($firstIndex, $maxResult);
        }

        //list($sortOn, $sortBy) = isset($request['SORT_BY']) ? explode('-', $request['SORT_BY']) : $this->selectConfig['sort'];
        $cols = json_decode($request['cols'], true);
        $sortOn = $cols[$request['order'][0]['column']]['data'];
        $sortBy = $request['order'][0]['dir'];
        // Sort result set
        $this->_set_sorting($sortOn, $sortBy);

        if ($this->selectConfig['responseType'] == 'result') {
            // This executes the query and returns the result
            $result = $this->client->select($this->selectQuery);

            // Generate Result
            return $this->_generate_result($result);
        } else {
            return ["solrClient" => $this->client, "query" => $this->selectQuery];
        }
    }

    /**
     * @param $result
     * @return array
     */
    public function _generate_result(&$result) {
        // List data
        $list = [];
        foreach ($result as $document) {
            $item = [];
            foreach ($document as $field => $value) {
                $item[$field] = $value;
            }
            $list[] = $item;
        }

        // Fetching facets
        $facets = [];
        foreach ($this->selectConfig['facets'] as $facetKey => $facet) {
            if ($facet['type'] == 'list') {
                $facetList = $result->getFacetSet()->getFacet($facetKey)->getValues();
                $facets[$facet['label']]['list'] = $facetList;
                $facets[$facet['label']]['type'] = $facet['type'];
                $facets[$facet['label']]['name'] = $facet['field'];
            }
        }

        // Count of record
        $listCount = $result->getNumFound();

        return ['list' => $list, 'recordCnt' => $listCount, 'facets' => $facets];
    }

    /**
     * @param $firstIndex
     * @param $maxResult
     */
    public function _set_limits($firstIndex, $maxResult) {
        $this->selectQuery->setStart($firstIndex)->setRows($maxResult);
    }

    /**
     * @param $sortOn
     * @param $sortBy
     */
    public function _set_sorting($sortOn, $sortBy) {
        $this->selectQuery->addSort($sortOn, $sortBy);
    }

    /**
     * @param $input
     */
    public function _set_facets_filters($input) {
        $facetSet = $this->selectQuery->getFacetSet();
        foreach ($this->selectConfig['facets'] as $facetKey => $facet) {
            if ($facet['type'] == 'list') {
                $facetSet->createFacetField($facetKey)->setField($facet['field'])->setSort("index");
                if (isset($input[$facet['field']])) {
                    $inputForFacets = str_replace("','", "\" OR \"", $input[$facet['field']]);
                    $inputForFacets = str_replace("'", "", $inputForFacets);
                    $this->selectQuery->createFilterQuery($facetKey)->setQuery($facet['field'] . ':("' . $inputForFacets . '")');
                }
            }
        }
    }

    /**
     * @param $input
     */
    public function _set_search_filter($input) {
        if ($this->selectConfig['search']['type'] == 'simple') {
            $searchParam = isset($input['search']['value']) ? $input['search']['value'] : '';
            if ($searchParam != '') {
                $searchParam = str_replace(" ", "\ ", $searchParam);
                $this->selectQuery->createFilterQuery('searchQuery')->setQuery(str_replace("###SEARCHTERM###", $searchParam, $this->selectConfig['search']['query']));
            }
        }
    }

    /**
     *
     */
    public function _set_basic_filters() {
        foreach ($this->selectConfig['filter'] as $filterKey => $filter) {
            $this->selectQuery->createFilterQuery($filterKey)->setQuery($filter);
        }
    }

    /**
     * @param $fields
     */
    public function _set_select_fields($fields) {
        $this->selectQuery->setFields($fields);
    }

    public function delete()
    {
        
    }

    /**
     * @param $entity
     * @param $id
     * @return mixed
     */
    public function indexer($entity, $id) {
        $indexerImportUri = $this->baseUri . "dataimport?command=full-import&clean=false&entity=" . $entity . "&id=" . $id;
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', $indexerImportUri);
        return json_decode($request->getBody()->getContents());
    }

    /**
     * @return mixed
     */
    public function fullImport() {
        $fullImportUri = $this->baseUri . "dataimport?command=full-import";
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', $fullImportUri);
        return json_decode($request->getBody()->getContents());
    }

    /**
     * @param null $entity
     * @return mixed
     */
    public function deltaImport($entity = null) {
        $deltaImportUri = $this->baseUri . "dataimport?command=delta-import&clean=false";
        if($entity != null) {
            $deltaImportUri .= "entity=" . $entity;
        }
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', $deltaImportUri);
        return json_decode($request->getBody()->getContents());
    }

    /**
     * @param $url
     * @return mixed
     */
    public function fireSolrCommand($url)
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', $url);
        return json_decode($request->getBody()->getContents());
    }

}