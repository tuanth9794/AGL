<?php

namespace App\Interfaces;


interface KeywordRepositoryInterface
{
	public function show($request);
    public function store($request,$keyword,$website);
}
