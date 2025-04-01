<?php

require_once("Model.php");

class Advertisement extends Model {
    protected $table = "Advertisement";

    public function getAllAdvertisements(){
        return $this->find();
    }

    /*
        Sample query:
        SELECT *, MATCH(Name, Description) AGAINST('?' IN NATURAL LANGUAGE MODE) AS relevance
        FROM $this->table
        WHERE 
         JSON_CONTAINS(Label, '?') AND
         JSON_CONTAINS(Label, '?') AND
         JSON_CONTAINS(Label, '?') AND
         UploadDate BETWEEN ? AND ?
         MATCH(title, content) AGAINST('?' IN NATURAL LANGUAGE MODE)
        ORDER BY relevance DESC
        LIMIT ?
    */
    public function getRecommendedAdvertisements(
        string $searchTerm, 
        array $tags = [], 
        ?string $before = null, 
        ?string $after = null,
        int $amount = 20,
        int $offset = 0
        ){
            
        $before = $before === null ? new Datetime($before) : new Datetime();
        $after = $after === null ? new Datetime($after) : new Datetime("1960/01/01 00:00:00");

        //Collects a list of strings to later implode with AND prefixed with WHERE
        $whereTerms = [];
        $orderClause = "ORDER BY ";
        $cols = ['*'];
        $values = [];

        //Construct tag search
        foreach($tags as $tag){
            $whereTerms[] = "JSON_CONTAINS(Label, '?')";
            $values[] = $tag;
        }

        //Construct date search
        $whereTerms[] = "UploadDate BETWEEN ? AND ?";
        $values[] = $before->format('Y-m-d H:i:s');
        $values[] = $after->format('Y-m-d H:i:s');

        //Construct name search 
        if(!empty($searchTerm)){
            $whereTerms[] = "MATCH(title, content) AGAINST('?' IN NATURAL LANGUAGE MODE)";
            $orderClause .= "relevance DESC ";
            $cols[] = "MATCH(Name, Description) AGAINST('?' IN NATURAL LANGUAGE MODE) AS relevance";
            array_unshift($values, $searchTerm);
            $values[] = $searchTerm;
        }

        //Add limit
        $whereTerms[] = "LIMIT ? OFFSET ?";
        $values[] = $amount;
        $values[] = $offset;

        $whereClause = "WHERE " . implode(" AND ", $whereTerms);

        return $this->find(cols: $cols, customValues: $values, customWhere: $whereClause, customOrder: $orderClause);
    }

}

?>