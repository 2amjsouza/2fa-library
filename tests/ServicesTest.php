<?php

use Da\TwoFA\Manager;
use Da\TwoFA\Service\QrCodeDataUriGeneratorService;
use Da\TwoFA\Service\TOTPSecretKeyUriGeneratorService;
use Da\TwoFA\Service\GoogleQrCodeUrlGeneratorService;

class ServicesTest extends \Codeception\Test\Unit
{

    const QRCODE = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAIAAAAiOjnJAAAFjklEQVR4nO3dwY6dOhBF0ZdW/v+TW28WMbhWV1Fn25DsNYzAkOSIW7JN8ev7+/s/Ke3r9A3o72SwhDBYQhgsIQyWEAZLCIMlhMESwmAJYbCEMFhCGCwhDJYQBksIgyWEwRLCYAnx+95pX1/5RE72sq7upzLm9dzJ8ZN7qFyrMuZz/l98YglhsIQwWELcrLGuiBqiWyusah269uoeU3EdZ3Jd4v+lMcLwfOkjgyWEwRIiUGNdVX6bK7/9q5opVUt1a7vuPVTqpMp1u8dMzs2+E+8TSwiDJYTBEiJcY6VUappU7dIdZzK/1a2Tun/f5/CJJYTBEsJgCfHQGitVT3Trs8pcVGp9s4vY78XxiSWEwRLCYAkRrrFSv/eT+ZvJuttkXio1p5Waw7vaX4f5xBLCYAlhsIQI1Fj0/E33Hrp7uVJ1zM77IfbaZ53PhP5KBksIgyXEzRqLnheZzPdUxunukUrNG+38dzvLJ5YQBksIgyXEgf5Yk/pmsme88udEP63KdbtOzY3V+cQSwmAJYbCECPfHIvpznuqrmeqVMJnTmvS56MrWWz6xhDBYQhgsIX6FuyIN9gntn2vJ3ltlnJXJfBgxl+Y8lh7KYAlhsIS4WWN1a5EVYn/3zj3jp+4z1XOV+xaQTywhDJYQBkuIcI21Mvnt795D6rs3k2Mqx+/8vmFq/MadbLiG/kEGSwiDJURgrXBnXTK5t5VT9VzFznm4ynXrfGIJYbCEMFhCHHivcDUO/Y4e0V+0gu4Zkfo39HuFegGDJYTBEiK85/2K6KW+Qvde33nd7nriE9ZtP4x24xzpRwZLCIMlxKa1wtXxFTvX4ybo2rE75s412Q8jB8eS/jBYQhgsIcJrhZW5EGLdrXsPK8QcUqoP1hPWZxtXgcbVP85gCWGwhAh/E3qFWAtL9XyvSNVAqZpm8u2gK+ex9DIGSwiDJUR4rfDq7e/craTWBIn9WKmeFKtr1fnEEsJgCWGwhAD7YxH7srvo3g1vGWfP+uCVTywhDJYQBksIcM/7zrWznf1FT/VKSL0LeeV+LL2MwRLCYAmx6Vs6qe/A0HvD6bW2U+9U7q+DfWIJYbCEMFhCBGqsnX2eiL1QlXFWx3Tvc4XucVUZx/1YegGDJYTBEgJ8r7Dye5/6RnL3XGJ/0qk+8t176J57j08sIQyWEAZLiPA8VuUYYq6L3seder+PQPQd9XuFeiiDJYTBEiIwj0V/f6Z7D6n9Ut37mczD7ezPvqdm9YklhMESwmAJEf5eIVHHpPpgPbmHFnHdSf3kPJYeymAJYbCEONAf69R7dk/o3bAap4J4p9LeDXoZgyWEwRICrLGuTn3jZWfPz8mYk3vY2S++zieWEAZLCIMlxIHeDal1w66d7/0RfSi6x6Tu5x6fWEIYLCEMlhDh3g2r3+nUXEuqbqNru+5eK7qv2Ir9sfQyBksIgyXEg/pjXaX2gxM9Rel3D7vndu3pK+ETSwiDJYTBEiL8XmHKpIZY2VmjPO27h/T3iz6McOMc6UcGSwiDJcTNeSy6BuoeQ+zBJ95D7N5D184+Wz+MHBxL+sNgCWGwhAisFRLv/VW+gVM5frIvavXn3f1hq3Em654rk7XLLJ9YQhgsIQyWEOH9WDt7JXT316fuJ7XulvomY2pO0d4NegGDJYTBEgLc807o1jGptT9iDTE195Za93StUC9gsIQwWEK8oMaavHM3qVdWxxPf5CHW+LrroZP7+XCV4fnSRwZLCIMlxKb+WCnEN3lW625P6MtVMVmLvMruwfeJJYTBEsJgCRGosYh3DFd29lufjEN892Zy3e68nfNYeiiDJYTBEuKh/bH0dj6xhDBYQhgsIQyWEAZLCIMlhMESwmAJYbCEMFhCGCwhDJYQBksIgyWEwRLCYAlhsIT4HybO2zx85W0PAAAAAElFTkSuQmCC';

    /**
     * @var Manager
     */
    protected $manager;

    protected function _before()
    {
        $this->manager = new Manager();
    }

    public function testGoogleQrCodeUrlGeneratorService()
    {
        $secret = 'ADUMJO5634NPDEKW';
        $totp = (new TOTPSecretKeyUriGeneratorService(
            '2amigos',
            'hola@2amigos.us',
            $secret
        ))->run();

        $url = (new GoogleQrCodeUrlGeneratorService($totp))->run();
        $this->assertStringEqualsFile(__DIR__ . '/_support/google.txt', $url);
    }

    public function testQrCodeDataUriGeneratorService()
    {
        $secret = 'ADUMJO5634NPDEKW';
        $totp = (new TOTPSecretKeyUriGeneratorService(
            '2amigos',
            'hola@2amigos.us',
            $secret
        ))->run();

        $uri = (new QrCodeDataUriGeneratorService($totp))->run();
        $this->assertStringEqualsFile(__DIR__ . '/_support/uri.txt', $uri);
    }

    public function testTOTPSecretKeyUriGeneratorService()
    {
        $secret = 'ADUMJO5634NPDEKW';
        $totp = (new TOTPSecretKeyUriGeneratorService(
            '2amigos',
            'hola@2amigos.us',
            $secret
        ))->run();

        $this->assertEquals('otpauth://totp/2amigos:hola%402amigos.us?secret=ADUMJO5634NPDEKW&issuer=2amigos', $totp);
    }
}
