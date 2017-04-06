<?php

namespace App\Traits;

/**
 * Helper functions for Images
 * Class Image
 * @package App\Traits
 */
trait File {

    /**
     * $this->storeFile($request, 'avatar')
     * @param \Illuminate\Http\Request $request
     * @param $fileName
     * @param string $folderName
     * @return false|string
     */
    protected function storeFile(\Illuminate\Http\Request $request, $fileName, $folderName = "public")
    {
        return $request->file($fileName)->store($folderName);
    }

    /**
     * $this->resizeImage($path, 400);
     * @param $path
     * @param $maxWidth
     * @param int $maxHeight
     * @internal param $maxSize
     * @return mixed
     */
    protected function resizeImage($path, $maxWidth, $maxHeight = 0)
    {
        if($maxHeight == 0) {
            $computedMaxHeight = $maxWidth;
        } else {
            $computedMaxHeight = $maxHeight;
        }
        $img = \Intervention\Image\Facades\Image::make(storage_path('app') . DIRECTORY_SEPARATOR . $path);
        $callback = function ($constraint) { $constraint->upsize(); };

        $thumbImageName = $this->thumbnailName($img->dirname, $img->basename, $maxWidth, $computedMaxHeight);
        $img->widen($maxWidth, $callback)->heighten($computedMaxHeight, $callback)->save($img->dirname . DIRECTORY_SEPARATOR . $thumbImageName);

        return $thumbImageName;
    }

    /**
     * @param $basePath
     * @param $imageName
     * @param $width
     * @param $height
     * @return mixed
     */
    private function thumbnailName($basePath, $imageName, $width, $height)
    {
        if(! \Illuminate\Support\Facades\Storage::has(str_replace(storage_path('app'), "", $basePath . DIRECTORY_SEPARATOR . $width . 'x' . $height))){
            \Illuminate\Support\Facades\Storage::makeDirectory(str_replace(storage_path('app'), "", $basePath . DIRECTORY_SEPARATOR . $width . 'x' . $height));
        }
        return $width . 'x' . $height . DIRECTORY_SEPARATOR . $imageName;
    }

    /**
     * deleteFile("avatars/b4h9yiAwsq4rCTszyTavLdHill3KVPYHurQ2dV0d.jpeg")
     * @param $filePath
     * @return bool
     */
    protected function deleteFile($filePath)
    {
        if(\Illuminate\Support\Facades\Storage::exists($filePath)) {
            return \Illuminate\Support\Facades\Storage::delete($filePath);
        }
        return false;
    }

    /** deleteFile("avatars/b4h9yiAwsq4rCTszyTavLdHill3KVPYHurQ2dV0d.jpeg")
     * @param $filePath
     * @return bool
     */
    protected function deleteAllImages($filePath)
    {
        if(\Illuminate\Support\Facades\Storage::exists($filePath)) {
            $img = \Intervention\Image\Facades\Image::make(storage_path('app') . DIRECTORY_SEPARATOR . $filePath);
            $allDirectories = \Illuminate\Support\Facades\Storage::allDirectories(str_replace(storage_path('app'), '', $img->dirname));
            foreach ($allDirectories as $directory) {
                if(\Illuminate\Support\Facades\Storage::exists($directory . DIRECTORY_SEPARATOR . $img->basename)) {
                    \Illuminate\Support\Facades\Storage::delete($directory . DIRECTORY_SEPARATOR . $img->basename);
                }
            }
            return \Illuminate\Support\Facades\Storage::delete($filePath);
        }
        return false;
    }

}