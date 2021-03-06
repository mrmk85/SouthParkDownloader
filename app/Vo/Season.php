<?php

namespace App\Vo;

/**
 * Representation of a season.
 * This file is part of the South Park Downloader package.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2020 Christian Raue
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3 License
 */
class Season {

	/**
	 * @var int Season number.
	 */
	private $number;

	/**
	 * @var Episode[]
	 */
	private $episodes = array();

	/**
	 * @param int Season number.
	 */
	public function __construct($number) {
		$this->number = $number;
	}

	public function getNumber() {
		return $this->number;
	}

	/**
	 * @param int $number Episode number.
	 * @return bool
	 */
	public function hasEpisode($number) {
		return $this->findEpisode($number) !== null;
	}

	/**
	 * @param Episode $newEpisode
	 */
	public function addEpisode(Episode $newEpisode) {
		$episode = $this->findEpisode($newEpisode->getNumber());

		if ($episode !== null) {
			throw new \RuntimeException(sprintf('Episode %u for S%02u already exists.', $episode->getNumber(), $this->number));
		}

		$this->episodes[] = $newEpisode;
	}

	/**
	 * @return Episode[]
	 */
	public function getAllEpisodes() {
		return $this->episodes;
	}

	/**
	 * @param int[] $numbers Episode numbers.
	 * @return Episode[]
	 */
	public function getEpisodes($numbers) {
		$episodes = [];

		foreach ($numbers as $number) {
			$episodes[] = $this->getEpisode($number);
		}

		return $episodes;
	}

	/**
	 * @param int $number Episode number.
	 * @return Episode
	 */
	public function getEpisode($number) {
		$episode = $this->findEpisode($number);

		if ($episode === null) {
			throw new \RuntimeException(sprintf('Episode %u for S%02u does not exist.', $number, $this->number));
		}

		return $episode;
	}

	/**
	 * @param int $number Episode number.
	 * @return Episode|null
	 */
	private function findEpisode($number) {
		foreach ($this->episodes as $episode) {
			if ($episode->getNumber() === $number) {
				return $episode;
			}
		}

		return null;
	}

}
