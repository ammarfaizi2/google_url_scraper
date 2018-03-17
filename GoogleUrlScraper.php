<?php

namespace IceTea\Google;

class GoogleUrlScraper
{
	private $query;

	private $limit;

	private $result = [];

	private $pager = 0;

	public function __construct($query, $limit = 10)
	{
		$this->query = $query;
		$this->limit = $limit;
	}

	public function exec()
	{
		while (
			$s = $this->pager() and
			count($this->result) < $this->limit and
			preg_match_all("/<h3 class=\"r\"><a href=\"(.*)\".+<\/h3>/Us", $s, $m)
		) {
			foreach ($m[1] as $val) {
				if (count($this->result) === $this->limit) {
					return;
				}
				$this->result[] = html_entity_decode($val, ENT_QUOTES, "UTF-8");
			}
			$this->pager+=10;
		}
	}

	private function pager()
	{
		$ch = curl_init("https://www.google.co.id/search?q=".urlencode($this->query)."&start=".$this->pager);
		curl_setopt_array($ch, 
			[
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0",
				CURLOPT_COOKIEFILE => getcwd()."/cookie.txt",
				CURLOPT_COOKIEJAR => getcwd()."/cookie.txt"
			]
		);
		$out = curl_exec($ch);
		curl_close($ch);
		return $out;
	}

	public function getResult()
	{
		return $this->result;		
	}
}
