<?php

namespace App\Http;

class ResizeImage
{
    const ResizeImageInfo = "本类对图像进行缩小，也可对png, gif, jpeg, wbmp格式的图像进行转换";
    //设置目标图像的宽和高
    private $height = 100;
    private $width = 100;
    //源图像文件和目标图像文件，若只是输出至浏览器则目标图像文件可不设置
    private $sourceFile = '';
    private $dstFile = '';
    //图像类型“image/gif、image/jpeg、image/png...”
    private $imgType;
    //源图像句柄和目标图像句柄
    private $sim;
    private $dim;
    //是否保存图像，用public void saveFlag(boolean $flag)方法设置
    private $saveFlag = true;

    //构造函数，当系统不支持GD库时给出异常信息
    function __construct()
    {
        if (!function_exists('imagecreate')) {
            throw new Exception('你的系统不支持GD库');
        }
    }

    //输出类作用信息
    function __toString()
    {
        return ReSizeImage::ResizeImageInfo;
    }

    //设置目标图像的宽
    public function setWidth($width)
    {
        if ($width <= 0) {
            throw new Exception('目标图像宽度不能小于0');
            return;
        }
        $this->width = $width;
    }

    //设置目标图像的高
    public function setHeight($height)
    {
        if ($height <= 0) {
            throw new Exception('目标图像高度不能小于0');
            return;
        }
        $this->height = $height;
    }

    //设置源图像文件
    public function setSourceFile($file)
    {
        if (!file_exists($file)) {
            throw new Exception('源图像文件不存在');
            return;
        }
        $this->sourceFile = $file;
    }

    //设置目标图像文件
    public function setDstFile($file)
    {
        $this->dstFile = $file;
    }

    //设置是否生成新文件
    public function saveFile($flag)
    {
        $this->saveFlag = (boolean)$flag;
    }

    //执行绘图操作，$quality参数表示生成图像的效果，数字越高，效果越好，不过仅用于jpeg类型的图像
    public function draw($quality = 95)
    {
        $sourceImgInfo = getimagesize($this->sourceFile);
        if (!is_array($sourceImgInfo)) {
            throw new Exception('源图像文件不存在');
            return;
        }
        switch ($sourceImgInfo[2]) {
            case 1:
                $this->imgType = "image/gif";
                $this->sim = imagecreatefromgif($this->sourceFile);
                break;
            case 2:
                $this->imgType = "image/jpeg";
                $this->sim = imagecreatefromjpeg($this->sourceFile);
                break;
            case 3:
                $this->imgType = "image/png";
                $this->sim = imagecreatefrompng($this->sourceFile);
                break;
            case 15:
                $this->imgType = "image/wbmp";
                $this->sim = imagecreatefromwbmp($this->sourceFile);
                break;
            default:
                return '不支持的图像格式';
                break;
        }

        //设置目标图像的实际宽和高
        $dstWidth = $sourceWidth = $sourceImgInfo[0];
        $dstHeight = $sourceHeight = $sourceImgInfo[1];
        if ($sourceHeight > $this->height && $sourceWidth > $this->width) {
            if ($sourceHeight > $sourceWidth) {
                $zoom = $this->height / $sourceHeight;
                $dstHeight = $this->height;
                $dstWidth = $sourceWidth * $zoom;
            } else {
                $zoom = $this->width / $sourceWidth;
                $dstWidth = $this->width;
                $dstHeight = $sourceHeight * $zoom;
            }
        }

        //建立目标图像的句柄
        $this->dim = @imagecreatetruecolor($dstWidth, $dstHeight) or imagecreate($dstWidth, $dstHeight);
        //将真彩色图像转换为调色板图像
//        imagetruecolortopalette($this->sim, false, 256);
        //根据源图像颜色的总数并把它分配到目标图像上
        $palsize = ImageColorsTotal($this->sim);
        for ($i = 0; $i < $palsize; $i++) {
            $colors = ImageColorsForIndex($this->sim, $i);
            ImageColorAllocate($this->dim, $colors['red'], $colors['green'], $colors['blue']);
        }
        
        //进行图像的缩放
        imagecopyresampled($this->dim, $this->sim, 0, 0, 0, 0, $dstWidth, $dstHeight, $sourceWidth, $sourceHeight);
        //生成新的目标图像
        if ($this->saveFlag) {
            $imgExt = substr($this->dstFile, strrpos($this->dstFile, '.') + 1);
            switch (strtolower($imgExt)) {
                case 'gif':
                    if (!function_exists('imagegif')) {
                        throw new Exception('你的GD库不支持gif图像的输出');
                        return;
                    }
                    imagegif($this->dim, $this->dstFile);
                    break;
                case 'jpeg':
                case 'jpg':
                    imagejpeg($this->dim, $this->dstFile, $quality);
                    break;
                case 'png':
                    imagepng($this->dim, $this->dstFile);
                    break;
                case 'wbmp':
                    imagewbmp($this->dim, $this->dstFile);
                    break;
                default:
                    return '目标图像文件为空或者格式不对，无法进行保存';
                    break;
            }
        }  else {
            //直接输出目标图像至浏览器
            header("Content-type: " . $this->imgType);
            switch ($sourceImgInfo[2]) {
                case 1:
                    imagegif($this->dim);
                    break;
                case 2:
                    imagejpeg($this->dim, '', $quality);
                    break;
                case 3:
                    imagepng($this->dim);
                    break;
                case 15:
                    imagewbmp($this->dim);
                    break;
                default:
                    return '不支持的图像格式';
                    break;
            }
        }
        return;
    }

    function __destruct()
    {
        @ImageDestroy($this->sim);
        @ImageDestroy($this->dim);
    }
}