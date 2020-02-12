<?php
declare(strict_types=1);
namespace BVMyBlog\Blog\Api\Data;

/**
 * Interface for post data.
 */
interface BlockInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const POST_ID = 'post_id';
    const TITLE = 'title';
    const POST_CONTENT = 'post_content';
    const IMG_PATH = 'img_path';
    const CREATED_AT = 'created_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get image path
     *
     * @return string|null
     */
    public function getImgPath();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set id
     *
     * @param string $id
     * @return string|null
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return BlockInterface
     */
    public function setTitle($title);

    /**
     * Set content
     *
     * @param string $content
     * @return BlockInterface
     */
    public function setContent($content);

    /**
     * Set image path
     *
     * @param string $imgPath
     * @return string|null
     */
    public function setImgPath($imgPath);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return BlockInterface
     */
    public function setCreationTime($creationTime);
}
