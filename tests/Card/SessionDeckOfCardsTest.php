<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ReflectionClass;

/**
 * A class containing a collection of tests for the SessionDeckOfCards class
 */
class SessionDeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object is a object, use no arguments.
     */
    public function testCreateSessionDeckOfCards(): void
    {
        $sessionDeck = new SessionDeckOfCards();
        $this->assertIsObject($sessionDeck);
    }

    /**
     * Tests the saveToSession method with the help of a
     * mock session to save to.
     */
    public function testSaveToSession(): void
    {
        $sessionMock = $this->createMock(SessionInterface::class);
        $sessionDeck = new SessionDeckOfCards();
        $cards = $sessionDeck->getCards();

        $reflection = new ReflectionClass($sessionDeck);
        $sessionKey = $reflection->getConstant('SESSION_KEY');

        $sessionMock->expects($this->once())
            ->method('set')
            ->with(
                $this->equalTo($sessionKey),
                $this->equalTo(serialize($cards))
            );
        $sessionDeck->saveToSession($sessionMock);
    }

    /**
     * Tests loading two cards from the loadFromSession method
     * with the help of a mock session to load from.
     */
    public function testLoadFromSessionWithCards(): void
    {

        $sessionMock = $this->createMock(SessionInterface::class);
        $sessionDeck = new SessionDeckOfCards();
        $cards = serialize([new Card('Hearts', 'Ace'), new Card('Spades', 'King')]);

        $reflection = new ReflectionClass($sessionDeck);
        $sessionKey = $reflection->getConstant('SESSION_KEY');

        $sessionMock->expects($this->once())
            ->method('get')
            ->with($this->equalTo($sessionKey))
            ->willReturn($cards);

        // Call the method under test
        $deck = SessionDeckOfCards::loadFromSession($sessionMock);

        // Assertions
        $this->assertInstanceOf(SessionDeckOfCards::class, $deck);
        $this->assertCount(2, $deck->getCards());
    }

    /**
     * Tests loading 0 cards from the loadFromSession method
     * with the help of a mock session to load from.
     * Expected return is null
     */
    public function testLoadFromSessionWithoutCards(): void
    {

        $sessionMock = $this->createMock(SessionInterface::class);
        $sessionDeck = new SessionDeckOfCards();

        $reflection = new ReflectionClass($sessionDeck);
        $sessionKey = $reflection->getConstant('SESSION_KEY');

        $sessionMock->expects($this->once())
            ->method('get')
            ->with($this->equalTo($sessionKey))
            ->willReturn(null);

        // Call the method under test
        $deck = SessionDeckOfCards::loadFromSession($sessionMock);

        // Assertions
        $this->assertNull($deck);
    }

}