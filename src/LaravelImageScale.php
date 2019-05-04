<?php

namespace Nddcoder\LaravelImageScale;

use Intervention\Image\Facades\Image as ImageManager;
use Intervention\Image\Image as Image;

class LaravelImageScale
{
    public function scale($source, $targetWidth, $targetHeight, $options = [])
    {
        $image = ImageManager::make($source);
        $originRatio = $image->width() / $image->height();
        $targetRatio = $targetWidth / $targetHeight;

        if ($originRatio > $targetRatio) {
            return $this->rowPadding($image, $targetWidth, $targetHeight, $targetRatio, $options);
        }

        return $this->colPadding($image, $targetWidth, $targetHeight, $targetRatio, $options);
    }

    protected function rowPadding(Image $image, $targetWidth, $targetHeight, $targetRatio, $options = [])
    {
        $width = $image->width();
        $height = $image->height();
        $scaledOriginHeight = $width / $targetRatio;
        $padding = (int) ceil(($scaledOriginHeight - $height) / 2);

        if ($padding < data_get($options, 'minimum_padding', 3)) {
            return $image->resize($targetWidth, $targetHeight);
        }

        $image
            ->crop($width, $scaledOriginHeight, 0, - $padding)
            ->rectangle(0 , 0, $width, $padding, function ($draw) use ($options) {
                $draw->background(data_get($options, 'padding_background', [255, 255, 255, 0]));
            })
            ->rectangle(0, $scaledOriginHeight - $padding, $width, $scaledOriginHeight, function ($draw) use ($options) {
                $draw->background(data_get($options, 'padding_background', [255, 255, 255, 0]));
            })
            ->resize($targetWidth, $targetHeight);

        return $image;
    }

    protected function colPadding(Image $image, $targetWidth, $targetHeight, $targetRatio, $options = [])
    {
        $width = $image->width();
        $height = $image->height();
        $scaledOriginWidth = $height * $targetRatio;
        $padding = (int) ceil(($scaledOriginWidth - $width) / 2);

        if ($padding < data_get($options, 'minimum_padding', 3)) {
            return $image->resize($targetWidth, $targetHeight);
        }

        $image
            ->crop($scaledOriginWidth, $height, - $padding, 0)
            ->rectangle(0 , 0, $padding, $height, function ($draw) use ($options) {
                $draw->background(data_get($options, 'padding_background', [255, 255, 255, 0]));
            })
            ->rectangle($scaledOriginWidth - $padding, 0, $scaledOriginWidth, $height, function ($draw) use ($options) {
                $draw->background(data_get($options, 'padding_background', [255, 255, 255, 0]));
            })
            ->resize($targetWidth, $targetHeight);

        return $image;
    }
}
