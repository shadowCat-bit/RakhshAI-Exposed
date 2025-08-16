<?php

namespace App\Services\Blog;

use Illuminate\Support\Facades\File;

class BlogPostService {

    // get last 5 blog posts
    public function getBlogPosts($take = 5) {
        // if (app()->environment('local') and File::exists("local-posts-$take.txt")) {
        //     return json_decode(File::get("local-posts-$take.txt"));
        // }
        $key = "blog.posts.$take";
        if (cache()->has($key)) {
            return json_decode(cache($key));
        }
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://rakhshai.com/news/wp-json/wp/v2/posts?_embed&per_page=$take&categories_exclude=28,21,30",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $blogPosts = curl_exec($curl);
        curl_close($curl);
        try {
            if ($blogPosts) {
                $blogPosts = json_decode($blogPosts);
                foreach ($blogPosts as $post) {
                    $image = (array)$post->_embedded;
                    $image = $image['wp:featuredmedia'][0]->source_url ?? $image['wp:featuredmedia'][0]->media_details->sizes->full->source_url;
                    $title = $post->title->rendered;
                    $title = str_replace('&#8217;', '’', $title);
                    $firstTitle = explode(' ', $post->title->rendered)[0];
                    $otherTitle = ltrim($title, $firstTitle);
                    $content = str_replace('&#8230;', '...', strip_tags($post->excerpt->rendered));
                    $content = str_replace('&nbsp;', ' ', $content);
                    $content = str_replace('&#8217;', '’', $content);
                    $json[] = [
                        'title'      => $title,
                        'firstTitle' => $firstTitle,
                        'otherTitle' => $otherTitle,
                        'content'    => $content,
                        'link'       => $post->link,
                        'thumbnail'  => $image,
                        'medium'     => $image,
                        'authorId'   => 0,
                        'author' => 'گروه تولید متحوای رخشای'
                    ];
                }
                $blogPosts = json_encode($json);
                cache()->put($key, $blogPosts, now()->addHour(24));

                return json_decode($blogPosts);
            }
        } catch (Throwable $ex) {
            return json_decode(cache($key));
        }
    }
}
