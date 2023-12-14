<?php
namespace App\Http\Middleware;
use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

class AwsS3{
    private $s3;

    public function __construct()
    {
        $credentials = new Credentials(
            "AKIAQOM5IBHQNOHEFOX5",
            "kP5oHwmdWmRuv4KiHU1MeNygYrPr6sja5crN5zni"
        );

        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => "us-east-2",
            'credentials' => $credentials,
        ]);

        if(!$this->s3){
            die();
        }
    }

    public function publish($filename, $content){
        try {
            $bucket = "clients-revi-nc-apply-articles";
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
            'region' => "us-east-2",
            'credentials' => [
                'key'    => "AKIAQOM5IBHQNOHEFOX5",
                'secret' => "kP5oHwmdWmRuv4KiHU1MeNygYrPr6sja5crN5zni",
            ],
        ]);

        $bucket = "clients-revi-nc-apply-articles";
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
