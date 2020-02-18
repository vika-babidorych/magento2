<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Api\Data;

/**
 * Interface for post data.
 */
interface BlogInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID = 'post_id';
    const TITLE = 'title';
    const POST_CONTENT = 'post_content';
    const IMAGE_PATH = 'image_path';
    const CREATED_AT = 'created_at';

    /**
     * Get ID
     *
     * @return int
     */
    public function getPostId() : int;

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
     * Get image path
     *
     * @return string
     */
    public function getImagePath() : string;

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreationTime() : string;

    /**
     * Set id
     *
     * @param string $id
     * @return BlogInterface
     */
    public function setPostId($id) : BlogInterface;

    /**
     * Set title
     *
     * @param string $title
     * @return BlogInterface
     */
    public function setTitle($title) : BlogInterface;

    /**
     * Set content
     *
     * @param string $content
     * @return BlogInterface
     */
    public function setContent($content) : BlogInterface;

    /**
     * Set image path
     *
     * @param string $imagePath
     * @return BlogInterface
     */
    public function setImagePath($imagePath) : BlogInterface;

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlogInterface
     */
    public function setCreationTime($creationTime) : BlogInterface;
}
