<?php

namespace Generate;

class CaptchaMaker
{
    /** @var string */
    private static $LETTERS = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "abcdefghijklmnopqrstuvwxyz" . "0123456789";

    /** @var  string */
    private $text;

    /** @var  resource */
    private $image;

    /**
     * Captcha constructor.
     * @param int $width
     * @param int $height
     * @param int $letters
     * @param int $lines
     * @param int $dots
     */
    public function __construct($width = 200, $height = 50, $letters = 6, $lines = 4, $dots = 50)
    {
        // create an image
        $this->image = imagecreatetruecolor($width, $height);

        // color it white
        $bg_color = imagecolorallocate($this->image, 255, 255, 255);
        imagefilledrectangle($this->image, 0, 0, $width, $height, $bg_color);

        // draw lines
        $line_color = imagecolorallocate($this->image, 0, 255, 0);
        for ($i = 0; $i < $lines; ++$i)
            imageline($this->image, 0, rand(0, $height), $width, rand(0, $height), $line_color);

        // draw dots
        $dot_color = imagecolorallocate($this->image, 255, 0, 0);
        for ($i = 0; $i < $dots; ++$i)
            imagesetpixel($this->image, rand(0, $width), rand(0, $height), $dot_color);

        // draw text
        $len = strlen(self::$LETTERS);
        $x0 = ($width - 2 * 20) / ($letters - 1);
        $y0 = ($height - 10) / 2;


        $text_color = imagecolorallocate($this->image, 0, 0, 255);
        for ($i = 0; $i < $letters; $i++) {
            $letter = self::$LETTERS[rand(0, $len - 1)];
            imagestring($this->image, 5, 20 + $i * $x0, $y0, $letter, $text_color);
            $this->text .= $letter;
        }
    }

    /**
     * @return resource
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

}