<?php
use Puppy\Application;
use Symfony\Component\HttpFoundation\Request;

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
    'post',
    function(Request $request){
        return $request->get('key');
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

$puppy->run();