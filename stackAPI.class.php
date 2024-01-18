<?php 

class stackAPI{
    private $apiKey;
    function __construct()
    {
        $this->apiKey = "mY0zhu6LcJysZf2KqoS6gOYsKdaEq6CkSjyFjjQycEDxSOfGNRbxzGUe";
    }
    public function get_stack($type = "curated", $qry = []){
        $url = "https://api.pexels.com/v1/{$type}";
     
        $http_build = "";
        if(!empty($qry))
            $http_build = "?".http_build_query($qry);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "{$url}{$http_build}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,[
            "Authorization: {$this->apiKey}"
        ]);

        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $status = ($httpCode == 200) ? "success" : "error";
        return [
            "status" => $status,
            "status_code" => $httpCode,
            "result" => json_decode($result, true)
        ];
    }
}

?>
