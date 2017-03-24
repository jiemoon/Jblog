<?php

function generate_article_url($article)
{
    return sprintf("/%s/%s", str_replace('-', '/', explode(' ', $article->publish_at)[0]), $article->slug);
}

function generate_article_date($publish_at)
{
    return date("M j, Y ", strtotime($publish_at));
}
