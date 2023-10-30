<?php
namespace App\Http\Middleware;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

class AwsS3{
    private $s3;

    public function __construct()
    {
        $credentials = new Credentials(
            env("AWS_ACCESS_KEY_ID"),
            env("AWS_SECRET_ACCESS_KEY")
        );

        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => env("AWS_DEFAULT_REGION"),
            'credentials' => $credentials,
        ]);

        if(!$this->s3){
            die();
        }
    }

    public function publish($filename, $content){
        try {
            $bucket = env("AWS_BUCKET");
            $key = date("Y/m").'/'.$filename;
            $this->s3->putObject([
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => $content,
            ]);
            return "https://{$bucket}.s3.amazonaws.com/{$key}";
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    static public function getFile($objUrl){
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => env("AWS_DEFAULT_REGION"),
            'credentials' => [
                'key'    => env("AWS_ACCESS_KEY_ID"),
                'secret' => env("AWS_SECRET_ACCESS_KEY"),
            ],
        ]);

        $bucket = env("AWS_BUCKET");
        $objectKey = str_replace("https://".$bucket.".s3.amazonaws.com/","", $objUrl);

        $expires = 3600*24; // 1 hora

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $objectKey,
        ]);

        $request = $s3->createPresignedRequest($cmd, "+{$expires} seconds");

        $presignedUrl = (string) $request->getUri();
        return $presignedUrl;
    }
}
