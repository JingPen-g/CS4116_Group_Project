<?php

require_once("Model.php");

class Advertisement extends Model {
    protected $table = "Advertisement";

    public function getAllAdvertisements() {
        return $this->find();
    }

    /*
        (
    SELECT 
        a.*,
        MATCH(a.Name, a.Description) AGAINST('' IN BOOLEAN MODE) AS relevance,
        COALESCE(AVG(r.Stars), 0) AS avg_review_score,
        1 AS is_relevant -- Flag to indicate matching ads
    FROM 
        Advertisement a
    LEFT JOIN 
        JSON_TABLE(a.Service_IDs, '$[*]' COLUMNS (id INT PATH '$')) AS jt
            ON TRUE
    LEFT JOIN 
        Service s ON s.Service_ID = jt.id
    LEFT JOIN 
        Review r ON r.Service_ID = s.Service_ID
    WHERE 
        (
            MATCH(a.Name, a.Description) AGAINST('' IN BOOLEAN MODE)
            OR a.Label->'$.labels' LIKE '%Reptile%'
        )
        AND a.UploadDate BETWEEN '1960-01-01 00:00:00' AND '2025-04-28 19:56:27'
    GROUP BY 
        a.Ad_ID
)
UNION
(
    SELECT 
        a.*,
        0 AS relevance, -- No relevance for non-matching ads
        COALESCE(AVG(r.Stars), 0) AS avg_review_score,
        0 AS is_relevant -- Flag to indicate non-matching ads
    FROM 
        Advertisement a
    LEFT JOIN 
        JSON_TABLE(a.Service_IDs, '$[*]' COLUMNS (id INT PATH '$')) AS jt
            ON TRUE
    LEFT JOIN 
        Service s ON s.Service_ID = jt.id
    LEFT JOIN 
        Review r ON r.Service_ID = s.Service_ID
    WHERE 
        (
            NOT MATCH(a.Name, a.Description) AGAINST('' IN BOOLEAN MODE)
            AND a.Label->'$.labels' NOT LIKE '%Reptile%'
        )
        AND a.UploadDate BETWEEN '1960-01-01 00:00:00' AND '2025-04-28 19:56:27'
    GROUP BY 
        a.Ad_ID
)
ORDER BY 
    is_relevant DESC, -- Prioritize matching ads
    relevance DESC,   -- Sort matching ads by relevance
    avg_review_score DESC -- Fallback sorting by review score
LIMIT 10 OFFSET 0;
    */
    public function getRecommendedAdvertisements(
        string $searchTerm = "", 
        array $tags = [], 
        ?string $before = null, 
        ?string $after = null,
        int $amount = 20,
        int $offset = 0
    ) {
        // Default date range
        $before = $before ? new DateTime($before) : new DateTime("1960-01-01 00:00:00");
        $after = $after ? new DateTime($after) : new DateTime();
    
        // Initialize values array for binding
        $values = [];
    
        // Base query components
        $queryConditions = [];
        $queryJoins = [];
    
        // Add search term condition
        $wildSearchTerm = "";
        $wildSearchTerm = $this->sanitizeInput($searchTerm);
        if (!empty($wildSearchTerm)) {
            $wildSearchTerm .= "*";
        }
        $values[] = $wildSearchTerm; // For MATCH in first subquery
        $values[] = $wildSearchTerm; // For MATCH in second subquery

        $tagPlaceholders = [];
    
        // Add tags condition (if needed)
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $sanitizedTag = $this->sanitizeInput($tag);
                $tagPlaceholders[] = "\"$sanitizedTag\"";
            }
        }
    
        // Add date range condition
        $beforeDate = $this->sanitizeInput($before->format('Y-m-d H:i:s'));
        $afterDate = $this->sanitizeInput($after->format('Y-m-d H:i:s'));
        $queryConditions[] = ") AND a.UploadDate BETWEEN ? AND ?";
        $values[] = $beforeDate;
        $values[] = $afterDate;
    
        // Construct the base query
        $query = "
            (
                SELECT 
                    a.*,
                    MATCH(a.Name, a.Description) AGAINST(? IN BOOLEAN MODE) AS relevance,
                    COALESCE(AVG(r.Stars), 0) AS avg_review_score,
                    1 AS is_relevant -- Flag to indicate matching ads
                FROM 
                    Advertisement a
                LEFT JOIN 
                    JSON_TABLE(a.Service_IDs, '$[*]' COLUMNS (id INT PATH '$')) AS jt
                    ON TRUE
                LEFT JOIN 
                    Service s ON s.Service_ID = jt.id
                LEFT JOIN 
                    Review r ON r.Service_ID = s.Service_ID
                WHERE
            ";

        $query .= " ( MATCH(a.Name, a.Description) AGAINST (? IN BOOLEAN MODE) ";
        if(!empty($tags)){
            $query .= " OR JSON_CONTAINS(a.Label->'$.labels', '[" . implode(", ", $tagPlaceholders) ."]') ";
        }

        // Append conditions for matching ads
        if (!empty($queryConditions)) {
            $query .= implode(" ", $queryConditions);
        }

        //Repeat the values for the second select 
        $values[] = $wildSearchTerm;

        $values[] = $beforeDate;
        $values[] = $afterDate;

        // Pagination
        $values[] = $amount;
        $values[] = $offset;
    
        $query .= "
                GROUP BY 
                    a.Ad_ID
            )
            UNION
            (
                SELECT 
                    a.*,
                    0 AS relevance, -- No relevance for non-matching ads
                    COALESCE(AVG(r.Stars), 0) AS avg_review_score,
                    0 AS is_relevant -- Flag to indicate non-matching ads
                FROM 
                    Advertisement a
                LEFT JOIN 
                    JSON_TABLE(a.Service_IDs, '$[*]' COLUMNS (id INT PATH '$')) AS jt
                    ON TRUE
                LEFT JOIN 
                    Service s ON s.Service_ID = jt.id
                LEFT JOIN 
                    Review r ON r.Service_ID = s.Service_ID
                WHERE
            ";
    
        // Append conditions for non-matching ads
        $query .= " ( NOT MATCH(a.Name, a.Description) AGAINST (? IN BOOLEAN MODE) ";
        if(!empty($tags)){
            $query .= " AND NOT JSON_CONTAINS(a.Label->'$.labels', '[" . implode(", ", $tagPlaceholders) ."]') ";
        }
    
        if (!empty($queryConditions)) {
            $query .= implode(" ", $queryConditions);
        }
        $query .= "
                GROUP BY 
                    a.Ad_ID
            )
            ORDER BY 
                is_relevant DESC, -- Prioritize matching ads
                relevance DESC,   -- Sort matching ads by relevance
                avg_review_score DESC -- Fallback sorting by review score
            LIMIT ? OFFSET ?
        ";

        // Execute the query
        return $this->query($query, $values);
    }
    
    protected function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }


    public function getAdvertInformation(string $Ad_ID){

        return $this->find(["Ad_ID" => $Ad_ID]);
    }

    public function insertAd($serviceDetails){

        return $this->insert($serviceDetails);
    }
}
