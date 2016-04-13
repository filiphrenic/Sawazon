<?php

namespace Processing\Image;

class ImageUpload
{

    private static $ROOT_DIR = __DIR__ . "/../../../images";

    /**
     * Uploads the given image to the given destination (in the images root folder)
     * Image will be converted from any valid type to png.
     * if the root folder for images is '/images' and given destination is 'user/2'
     * image will be uploaded to /images/user/2.png
     *
     * Very rigorous testing, never trust the user.
     *
     * @param array $uploaded_file one item from $_FILES array
     * @param string $destination destination where you want to upload the file
     * @param int $max_width
     *
     * @return false | string error
     */
    static function upload(array $uploaded_file, $destination, $max_width = 500)
    {
        if (!is_array($uploaded_file) || empty($uploaded_file))
            return false;

        $current_path = $uploaded_file['tmp_name'];
        $destination = self::$ROOT_DIR . '/' . $destination . '.png';

        // error checking
        if ($uploaded_file['error'] != UPLOAD_ERR_OK)
            return "Error occurred while uploading image to server";

        if (!is_uploaded_file($current_path))
            return "File wasn't uploaded";

        $f = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $f->file($current_path);
        finfo_close($f);

        if (!preg_match("%^image/.+$%", $mime_type))
            return "Uploaded file is not an image";

        if (!($info = getimagesize($current_path)))
            return "Uploaded file is not an image";

        if ($info[0] === 0 || $info[1] === 0)
            return "Invalid image size";

        $mime_type = $info[2];
        $mime_supported = [IMAGETYPE_PNG, IMAGETYPE_JPEG2000, IMAGETYPE_JPEG];
        if (!in_array($mime_type, $mime_supported))
            return "File mime type not supported";

        // actual upload
        $im = imagecreatefromstring(file_get_contents($current_path));
        if (!$im) return "Can't read image";

        // TODO create smaller image


        imagepng($im, $destination);
        imagedestroy($im);

        return false;
    }
}