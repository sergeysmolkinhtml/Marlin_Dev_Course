<?php

namespace App\Services;

use Exception;

class Image
{
    public static function upload() : void
    {
        try {
            // Create a new SimpleImage object
            $image = new \claviska\SimpleImage();

            // Magic! ✨
            $image
                ->fromFile('image.jpg')                     // load image.jpg
                ->autoOrient()                              // adjust orientation based on exif data
                ->resize(320, 200)                          // resize to 320x200 pixels
                ->flip('x')                                 // flip horizontally
                ->colorize('DarkBlue')                      // tint dark blue
                ->border('black', 10)                       // add a 10 pixel black border
                ->overlay('watermark.png', 'bottom right')  // add a watermark image
                ->toFile('new-image.png', 'image/png')      // convert to PNG and save a copy to new-image.png
                ->toScreen();                               // output to the screen

            // And much more! 💪
        } catch(Exception $err) {
            // Handle errors
            echo $err->getMessage();
        }
    }
}