<?php
namespace App\Service;
use Psr\Log\LoggerInterface;

class SongService
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getRandomArtist(): string
    {

        return 'Gardel';
    }
}