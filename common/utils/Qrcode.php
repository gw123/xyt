<?php
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

namespace  common\utils;
use common\utils\Gd;
class Qrcode {

    public  static function  generateCode()
   {
       //include ROOT_PATH."/lib/phpqrcode/qrlib.php";
       //include ROOT_PATH."/lib/Gd.php";
       $path =\Yii::getAlias('@vendor');
       include $path."/phpqrcode/qrlib.php";
        //set it to writable location, a place for temp generated PNG files

        $dataPath = \Yii::$app->params['DataPath'];
        $PNG_TEMP_DIR = $dataPath.'/files/qrcode/';
        //html PNG location prefix
        $PNG_WEB_DIR  = '/files/qrcode/';
        //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))  mkdir($PNG_TEMP_DIR);

        $filename = $PNG_TEMP_DIR.'test.png';
        //processing form input
        //remember to sanitize user input in real-life solution !!!
       echo "<h1>二维码</h1><hr/>";
        $errorCorrectionLevel = 'L';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            $errorCorrectionLevel = $_REQUEST['level'];

        $matrixPointSize = 4;
        if (isset($_REQUEST['size']))
            $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

        if (isset($_REQUEST['data'])) {
            //it's very important!
            if (trim($_REQUEST['data']) == '')   die('data cannot be empty! <a href="?">back</a>');
            // user data
            $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
            \QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

            $gd = new Gd($filename);
            $gd->water($dataPath."/logo.jpeg",Image::IMAGE_WATER_CENTER , 95);
            $gd->save($filename);
        }

        //display generated file
        echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';
        //config form
        echo '<form action="" method="post">
       二维码信息:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'PHP QR Code :)').'" />&nbsp;
        ECC:&nbsp;<select name="level">
            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
        </select>&nbsp;
        Size:&nbsp;<select name="size">';

        for($i=1;$i<=10;$i++)
            echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';

         echo '</select>&nbsp;
        <input type="submit" value="GENERATE"></form><hr/>';

        // benchmark
        \QRtools::timeBenchmark();
   }
}









