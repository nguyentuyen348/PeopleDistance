<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UploadFileController extends Controller
{
    public function saveFile($file_upload)
    {
        $WIDTH = 600; // The size of your new image
        $HEIGHT = 700; // The size of your new image
        $WIDTH_DOC = 1024;  // The size of your new image
        $HEIGHT_DOC = 600;  // The size of your new image
        $QUALITY = 100; //The quality of your new image
        if (preg_match('/^data:image\/(\w+);base64,/', $file_upload, $type)) {
            $file_upload = substr($file_upload, strpos($file_upload, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                //  throw new \Exception('invalid img type');
                $errors = 'invalid type';
                throw new HttpResponseException(response()->json(
                    [
                        'error' => $errors,
                        'status_code' => 422,
                        'messages' => 'sai định dạng file'
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                ));
            }
            $file_upload = str_replace(' ', '+', $file_upload);
            $file_upload = base64_decode($file_upload);

            $dir = 'images/';
            $file = Str::random() . '.' . $type;
            $absolutePath = public_path($dir);
            $relativePath1 = $dir . $file;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            file_put_contents($relativePath1, $file_upload);

            list($width_orig, $height_orig) = getimagesize($relativePath1);

            if ($width_orig > $height_orig) {
                $ratio_orig = $width_orig / $height_orig;
                $WIDTH_res = $WIDTH_DOC;
                $HEIGHT_res = $WIDTH_DOC / $ratio_orig;
            } elseif ($width_orig < $height_orig) {
                $ratio_orig = $width_orig / $height_orig;
                $WIDTH_res = $WIDTH;
                $HEIGHT_res = $WIDTH / $ratio_orig;
            } else {
                $WIDTH_res = $HEIGHT;
                $HEIGHT_res = $HEIGHT;
            }

            $file_upload1 = imagecreatefromstring($file_upload);

            $file_upload_little = imagecreatetruecolor($WIDTH_res, $HEIGHT_res);

            // $org_w and org_h depends of your image, in your case, i guess 800 and 600
            imagecopyresampled($file_upload_little, $file_upload1, 0, 0, 0, 0, $WIDTH_res, $HEIGHT_res, $width_orig, $height_orig);

            // Thanks to Michael Robinson
            // start buffering

            ob_start();
            imagepng($file_upload_little);
            $contents = ob_get_contents();
            ob_end_clean();

            $file_upload2 = $contents;

            $dir = 'images/';
            $file = Str::random() . '.' . $type;
            $absolutePath = public_path($dir);
            $relativePath = $dir . $file;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            file_put_contents($relativePath, $file_upload2);

        } elseif (preg_match('/^data:application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,/', $file_upload, $type)) {
            $file = substr($file_upload, strpos($file_upload, ',') + 1);
            $type = strtolower($type[0]);
            if (!in_array($type, ['data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'])) {
                //  throw new \Exception('invalid file type');
                $errors = 'invalid type';
                throw new HttpResponseException(response()->json(
                    [
                        'error' => $errors,
                        'status_code' => 422,
                        'messages' => 'sai định dạng file'
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                ));
            }
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);
            $dir = 'files/xlsx/';
            $time_now = $this->timeNow->toDateString();
            $files = $time_now . Str::random() . '.' . 'xlsx';
            $absolutePath = public_path($dir);
            $relativePath = $dir . $files;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            file_put_contents($relativePath, $file);
        } elseif (preg_match('/^data:application\/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,/', $file_upload, $type)) {
            $file = substr($file_upload, strpos($file_upload, ',') + 1);
            $type = strtolower($type[0]);
            if (!in_array($type, ['data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,'])) {
                //  throw new \Exception('invalid file type');
                $errors = 'invalid type';
                throw new HttpResponseException(response()->json(
                    [
                        'error' => $errors,
                        'status_code' => 422,
                        'messages' => 'sai định dạng file'
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                ));
            }
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);
            $dir = 'files/docx/';
            $time_now = $this->timeNow->toDateString();
            $files = $time_now . Str::random() . '.' . 'docx';
            $absolutePath = public_path($dir);
            $relativePath = $dir . $files;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            file_put_contents($relativePath, $file);
        } elseif (preg_match('/^data:application\/pdf;base64,/', $file_upload, $type)) {
            $file = substr($file_upload, strpos($file_upload, ',') + 1);
            $type = strtolower($type[0]);
            if (!in_array($type, ['data:application/pdf;base64,'])) {
                //  throw new \Exception('invalid file type');
                $errors = 'invalid type';
                throw new HttpResponseException(response()->json(
                    [
                        'error' => $errors,
                        'status_code' => 422,
                        'messages' => 'sai định dạng file'
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                ));
            }
            $file = str_replace(' ', '+', $file);
            $file = base64_decode($file);
            $dir = 'files/pdf/';
            $time_now = $this->timeNow->toDateString();
            $files = $time_now . Str::random() . '.' . 'pdf';
            $absolutePath = public_path($dir);
            $relativePath = $dir . $files;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            file_put_contents($relativePath, $file);
        } else {
            //  throw new \Exception('did not match data URI with img data');
            $errors = 'did not match data URI with img data';
            throw new HttpResponseException(response()->json(
                [
                    'error' => $errors,
                    'status_code' => 422,
                    'messages' => 'sai định dạng file'
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            ));
        }
        return $relativePath;
    }

    public function upload(Request $request)
    {
        $file = $request->file;

        if ($file) {
            foreach ($file as $item) {
                $files[] = $this->saveFile($item);
            }
        } else {
            $files = [];
        }

        $data = [
            'status' => 'success',
            'file' => $files
        ];

        return response()->json($data);

    }

}
