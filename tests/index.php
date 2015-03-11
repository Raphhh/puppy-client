<?php
use Puppy\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

@include_once __DIR__.'/../vendor/autoload.php';

$puppy = new Application(new ArrayObject(), Request::createFromGlobals());

$puppy->any(
    'request-uri',
    function(Request $request){
        return $request->getRequestUri();
    }
);

$puppy->any(
    'method',
    function(Request $request){
        return $request->getMethod();
    }
);

$puppy->any(
    'get',
    function(){
        return $_GET['key'];
    }
);

$puppy->any(
    'post',
    function(){
        return $_POST['key'];
    }
);

$puppy->any(
    'server',
    function(){
        return $_SERVER['key'];
    }
);

$puppy->any(
    'cookie',
    function(){
        return $_COOKIE['key'];
    }
);

$puppy->any(
    'env',
    function(){
        return $_ENV['key'];
    }
);

$puppy->any(
    'text-html',
    function(Request $request){
        return $request->getAcceptableContentTypes() ? 'set type' : 'no type';
    }
);

$puppy->any(
    'application-json',
    function(Request $request){
        return $request->getAcceptableContentTypes()[0];
    }
);

$puppy->any(
    'click',
    function(){
        return '<div><a href="request-uri">link</a></div>';
    }
);

$puppy->any(
    'submit',
    function(){
        return '<div>
                    <form action="post" method="post">
                        <input type="hidden" name="key" value="">
                        <input type="submit" name="submit" value="submit">
                    </form>
                </div>';
    }
);

$puppy->any(
    'response',
    function(){
        return new Response('response content', 201, ['Age' => '12']);
    }
);

$puppy->run();