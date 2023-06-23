<?php

namespace App\Interfaces;


interface KeywordRepositoryInterface
{
	public function show();
    public function store($request);
}
