<?php
declare(strict_types=1);

namespace BVMyBlog\Blog\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Setups the database structure
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install the database structure
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $context->getVersion();
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('bvmyblog_blog_post')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('bvmyblog_blog_post')
            )
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Post ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Post Title'
                )
                ->addColumn(
                    'post_content',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Post Post Content'
                )
                ->addColumn(
                    'img_path',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Post Image Path'
                )

                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )

                ->setComment('Post Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('bvmyblog_blog_post'),
                $setup->getIdxName(
                    $installer->getTable('bvmyblog_blog_post'),
                    ['post_id'],
                    AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['post_id'],
                AdapterInterface::INDEX_TYPE_INDEX
            );
        }
        $installer->endSetup();
    }
}
