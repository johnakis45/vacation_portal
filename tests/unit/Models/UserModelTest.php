<?php

use PHPUnit\Framework\TestCase;
use App\models\UserModel;

class UserModelTest extends TestCase
{
    private $userModel;

    protected function setUp(): void
    {
        $this->userModel = new UserModel();
    }

    protected function tearDown(): void
    {
        // Clean up any changes made during testing
        $this->userModel = null;
    }

    protected function generateUniqueCode(): string
    {
        return substr(str_shuffle('0123456789'), 0, 7);
    }

    protected function generateRandomString($length = 10): string
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    /**
     * Test inserting a new user.
     */
    public function testInsertUser(): void
    {
        $this->userModel->setUsername($this->generateRandomString());
        $this->userModel->setEmail($this->generateRandomString() .'@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode($this->generateUniqueCode());
        $this->userModel->setRole('user');

        $result = $this->userModel->insertUser();
        $this->assertTrue($result, 'User insertion should succeed.');
    }

    /**
     * Test fetching a user by ID.
     */
    public function testFetchUserById(): void
    {
        // Fetch the user by ID
        $this->userModel->fetchUserById(1);

        $this->assertEquals('admin', $this->userModel->getUsername(), 'Username should match.');
        $this->assertEquals('admin@epignosishq.com', $this->userModel->getEmail(), 'Email should match.');
    }

    /**
     * Test fetching a user by username.
     */
    public function testFetchUserByUsername(): void
    {
        // Insert a test user first
        $name = $this->generateRandomString();

        $this->userModel->setUsername($name);
        $this->userModel->setEmail( $name .'@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode($this->generateUniqueCode());
        $this->userModel->setRole('user');
        $this->userModel->insertUser();

        // Fetch the user by username
        $this->userModel->fetchUserByUsername($name);

        $this->assertEquals($name, $this->userModel->getUsername(), 'Username should match.');
        $this->assertEquals($name . '@example.com', $this->userModel->getEmail(), 'Email should match.');
    }

    /**
     * Test updating a user.
     */
    public function testUpdateUser(): void
    {
        $name = $this->generateRandomString();
        // Insert a test user first
        $this->userModel->setUsername($name);
        $this->userModel->setEmail($name.'@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode($this->generateUniqueCode());
        $this->userModel->setRole('user');
        $this->userModel->insertUser();

        $this->userModel->fetchUserByUsername($name);

        $newName = $this->generateRandomString();
        // Update the user
        $this->userModel->setUsername($newName );
        $this->userModel->setEmail($newName .'@example.com');
        $result = $this->userModel->updateUser($this->userModel->getId());

        $this->assertTrue($result, 'User update should succeed.');

        // Fetch the updated user
        $this->userModel->fetchUserById($this->userModel->getId());
        $this->assertEquals($newName , $this->userModel->getUsername(), 'Username should be updated.');
        $this->assertEquals($newName .'@example.com', $this->userModel->getEmail(), 'Email should be updated.');
    }

    /**
     * Test removing a user.
     */
    public function testRemoveUser(): void
    {
        $name = $this->generateRandomString();
        // Insert a test user first
        $this->userModel->setUsername($name);
        $this->userModel->setEmail($name .'@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode($this->generateUniqueCode());
        $this->userModel->setRole('user');
        $this->userModel->insertUser();

        $this->userModel->fetchUserByUsername($name);

        $userId = $this->userModel->getId();

        // Remove the user
        $this->userModel->removeUser($userId);

        // Try to fetch the removed user
        //$this->userModel->fetchUserById($userId);
        $this->assertFalse($this->userModel->fetchUserById($userId), 'User should be removed.');
    }

    /**
     * Test user authentication.
     */
    public function testAuthenticateUser(): void
    {
        // Insert a test user first
        $this->userModel->setUsername('testuser');
        $this->userModel->setEmail('testuser@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode($this->generateUniqueCode());
        $this->userModel->setRole('user');
        $this->userModel->insertUser();

        // Authenticate the user
        $this->userModel->setUsername('testuser');
        $result = $this->userModel->authenticateUser('password123');

        $this->assertTrue($result, 'User authentication should succeed.');
    }

    /**
     * Test fetching all users (excluding managers).
     */
    public function testFetchAllUsers(): void
    {
        // Insert test users
        $this->userModel->setUsername('testuser1');
        $this->userModel->setEmail('testuser1@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode('ABC123');
        $this->userModel->setRole('user');
        $this->userModel->insertUser();

        $this->userModel->setUsername('testuser2');
        $this->userModel->setEmail('testuser2@example.com');
        $this->userModel->setPassword('password123');
        $this->userModel->setUniqueCode('XYZ456');
        $this->userModel->setRole('admin');
        $this->userModel->insertUser();

        // Fetch all users (excluding managers)
        $users = $this->userModel->fetchAllUsers();

        $this->assertGreaterThanOrEqual(2, count($users), 'There should be at least 2 users (excluding managers).');
    }
}