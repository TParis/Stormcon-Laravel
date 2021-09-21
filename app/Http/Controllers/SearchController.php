<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Algolia\AlgoliaSearch\SearchClient;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{
    public function Search(Request $request) {

        $query = $request->search;
        $page = (isset($request->page)) ? $request->page : 1;

        $client = SearchClient::create(Config("scout.algolia.id"), Config("scout.algolia.secret"));

        $queries = [
            [
                'indexName' => 'projects',
                'query' => $query,
            ],
            [
                'indexName' => 'users',
                'query' => $query,
            ],
            [
                'indexName' => 'companies',
                'query' => $query,
            ],
            [
                'indexName' => 'contacts',
                'query' => $query,
            ]
        ];

        $results = $client->multipleQueries($queries);

        $results = $this->Merge_Results($results);

        //We have results, now lets paginate

        $paginator = $this->Paginate($results, $page, $query);

        return response()->view("search.index", compact("paginator", "query"));

    }

    public function Merge_Results($search) {

        $response = Collect();

        foreach ($search["results"] as $index) {
            $data = Collect($index["hits"])->map(function ($item) use ($index) {
                $item["index"] = $index["index"];
                return $item;
            });

            $response = $response->merge($data);
        }
        return $response;
    }

    private function Paginate($results, $page, $query)
    {
        $results = $results->sortBy("updated_at");

        $results = array_slice($results->toArray(), 15 * ($page - 1));

        $paginator = new Paginator($results, 15, $page);

        $paginator->withPath('/search')->appends(['search' => $query]);

        return $paginator;
    }
}
