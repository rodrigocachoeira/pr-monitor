<?php

namespace App\Repositories;

use App\Enums\ReviewStatus;
use App\Repositories\Contracts\GithubRepositoryContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GithubRepositoryApi implements GithubRepositoryContract
{
    public function __construct(private readonly Client $client)
    {}
    
    public function getPullRequests(string $repositoryName): Collection
    {
        $perPage = config('github.components.repos.per_page');
        $owner = config('github.owner');
        $url = implode(['/repos/', $owner, '/', $repositoryName, '/pulls?per_page=', $perPage]);

        return $this->getPullRequestsByPagination($url);
    }

    public function getConsultantsOfTeams(array $requestedTeams): Collection
    {
        return collect($requestedTeams)->map(function ($request) {
            return [
                'name' => $request['name'],
                'slug' => $request['slug'],
            ];    
        });
    }

    public function getPullRequestApproves(string $repositoryName, string $pullRequestNumber): Collection
    {
        $owner = config('github.owner');
        $url = implode(['/repos/', $owner, '/', $repositoryName, '/pulls/', $pullRequestNumber  ,'/reviews']);
        
        $reviews = $this->getRequest($url);
        
        return collect($reviews)
            ->filter(function ($review) {
                return $review['state'] == ReviewStatus::APPROVED->value;
            })
            ->map(function ($review) {
                return [
                    'author' => Arr::get($review, 'user.login'),
                    'avatarUrl' => Arr::get($review, 'user.avatar_url'),
                    'reviewedAt' => Arr::get($review, 'submitted_at'),
                ];
            })
            ->unique('author');
    }

    public function getChangedFilesPullRequest(string $repositoryName, string $pullRequestNumber): Collection
    {
        $owner = config('github.owner');
        $url = implode(['/repos/', $owner, '/', $repositoryName, '/pulls/', $pullRequestNumber  ,'/files']);
        
        $res = $this->getRequest($url);
        
        return collect($res)->pluck('filename');
    }
    
    private function getPullRequestsByPagination(string $url): Collection
    {
        $page = 1;
        $hasMorePage = true;
        $pullRequests = collect();
        
        while ($hasMorePage) {
            $res = $this->getHttpPulls($url, $page);
            
            $hasMorePage = $page < $res['lastPage'];
            $pullRequests = $pullRequests->concat($res['data']);
            
            $page++;
        }
        
        return $pullRequests;
    }
    
    private function getRequest(string $url)
    {
        try {
            $response = $this->client->get($url);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());

            return [];
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getHttpPulls(string $request, int $page): array
    {
        try {
            $url = $request . '&page=' . $page;
            $response = $this->client->get($url);
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());

            return [];
        }

        $data = json_decode($response->getBody()->getContents(), true);
        $lastPage = $this->getLastPage($response->getHeader('link')[0] ?? null);
        
        return [
            'data' => $data,
            'lastPage' => $lastPage,
        ];
    }

    private function getLastPage($link): int {
        if ($link) {
            $last = explode(",", $link)[1];
            $pageParts = explode("page=", $last);
            if (isset($pageParts[2])) {
                return explode(">", $pageParts[2])[0];
            }
        }

        return 999;
    }
}
