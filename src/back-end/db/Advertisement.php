<?php

require_once("Model.php");

class Advertisement extends Model {
    protected $table = "Advertisement";

    public function getAllAdvertisements() {
        return $this->find();
    }

    /*
        Sample query:
        SELECT *, MATCH(Name, Description) AGAINST(?) AS relevance
        FROM Advertisement
        WHERE 
            JSON_CONTAINS(Label, ?) AND
            UploadDate BETWEEN ? AND ?
        ORDER BY relevance DESC
        LIMIT ? OFFSET ?
    */
    public function getRecommendedAdvertisements(
        string $searchTerm, 
        array $tags = [], 
        ?string $before = "", 
        ?string $after = "",
        int $amount = 20,
        int $offset = 0
    ) {
        if(empty($searchTerm)) return $this->find();

        // Default date range
        $before = $before ? new DateTime($before) : new DateTime("1960-01-01 00:00:00");
        $after = $after ? new DateTime($after) : new DateTime();

        // Initialize query components
        $whereTerms = [];
        $orderTerms = [];
        $cols = ['*'];
        $values = [];

        // Construct tag search
        foreach ($tags as $tag) {
            $whereTerms[] = "JSON_CONTAINS(Label, ?, '$.labels')";
            $val = '"' . $tag . '"';
            $values[] = &$val; // JSON tags must be encoded as strings
        }

        // Construct date search
        $whereTerms[] = "UploadDate BETWEEN ? AND ?";
        $beforeDate = $before->format('Y-m-d H:i:s');
        $afterDate = $after->format('Y-m-d H:i:s');
        $values[] = &$beforeDate;
        $values[] = &$afterDate;

        // Construct name search
        if (!empty($searchTerm)) {
            $whereTerms[] = "MATCH(Name, Description) AGAINST(? IN BOOLEAN MODE)";
            $orderTerms[] = "ORDER BY relevance DESC";
            $cols[] = "MATCH(Name, Description) AGAINST(? IN BOOLEAN MODE) AS relevance";
            $wildSearchTerm = $searchTerm . '*';
            array_unshift($values, null);
            $values[0] = &$wildSearchTerm; 
            $values[] = &$wildSearchTerm; 
        }

        // Add limit and offset
        $orderTerms[] = " LIMIT ? OFFSET ? ";
        $values[] = &$amount;
        $values[] = &$offset;

        // Combine query components
        $whereClause = !empty($whereTerms) ? implode(" AND ", $whereTerms) : " ";
        $orderClause = !empty($orderTerms) ? implode(" ", $orderTerms) : " ";

        // Execute query
        return $this->find(
            cols: $cols,
            customValues: $values,
            customWhere: $whereClause,
            customExtra: $orderClause
        );
    }
}