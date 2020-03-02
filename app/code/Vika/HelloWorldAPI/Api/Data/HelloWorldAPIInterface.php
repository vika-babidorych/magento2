<?php
declare(strict_types=1);

namespace Vika\HelloWorldAPI\Api\Data;

/**
 * Interface for data.
 */
interface HelloWorldAPIInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const TITLE = 'title';
    const CONTENT = 'content';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() : string;

    /**
     * Get content
     *
     * @return string
     */
    public function getContent() : string;

    /**
     * Set id
     *
     * @param string $id
     * @return HelloWorldAPIInterface
     */
    public function setId($id) : HelloWorldAPIInterface;

    /**
     * Set title
     *
     * @param string $title
     * @return HelloWorldAPIInterface
     */
    public function setTitle($title) : HelloWorldAPIInterface;

    /**
     * Set content
     *
     * @param string $content
     * @return HelloWorldAPIInterface
     */
    public function setContent($content) : HelloWorldAPIInterface;
}
