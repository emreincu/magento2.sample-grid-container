<?php

namespace Emakina\Blog\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();

		if (!$installer->tableExists('emakina_blog_posts')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('emakina_blog_posts')
			)
			
			->addColumn(
					'post_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
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
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					120,
					[
						'nullable' => false
					],
					'Post Title'
				)
				->addColumn(
					'content',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					\Magento\Framework\DB\Ddl\Table::MAX_TEXT_SIZE,
					[
						'nullable' => false
					],
					'Post Content'
				)
				->addColumn(
					'view_count',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'default' => 0
					],
					'Post View Count'
				)
				->addColumn(
					'url',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					200,
					[
						'nullable' => false
					],
					'Post URL'
				)
				->addColumn(
					'tags',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					\Magento\Framework\DB\Ddl\Table::DEFAULT_TEXT_SIZE,
					[
						'nullable' => true
					],
					'Post Tags'
				)
				->addColumn(
					'is_active',
					\Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
					null,
					[
						'nullable' => false,
						'default' => 1
					],
					'Post Status'
				)
				->addColumn(
					'image',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
						'nullable' => true
					],
					'Post Image'
				)
				->addColumn(
					'created_date',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					[
						'nullable' => false,
						'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
					],
					'Post Created Date'
				)->addColumn(
					'modified_date',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					[
						'nullable' => false,
						'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
					],
					'Post Updated Date'
				)
				->setComment('Post Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('emakina_blog_posts'),
				$setup->getIdxName(
					$installer->getTable('emakina_blog_posts'),
					['title'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
				),
				['title'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
			);
		}


		// if (!$installer->tableExists('emakina_blog_comments')) {
		// 	$table = $installer->getConnection()->newTable(
		// 		$installer->getTable('emakina_blog_comments')
		// 	)->addColumn(
		// 			'comment_id',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
		// 			null,
		// 			[
		// 				'identity' => true,
		// 				'nullable' => false,
		// 				'primary'  => true,
		// 				'unsigned' => true,
		// 			],
		// 			'Comment ID'
		// 		)
		// 		->addColumn(
		// 			'post_id',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
		// 			null,
		// 			[
		// 				'nullable' => false,
		// 				'unsigned' => true,
		// 			],
		// 			'Post ID'
		// 		)
		// 		->addColumn(
		// 			'user_id',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
		// 			null,
		// 			[
		// 				'nullable' => false
		// 			],
		// 			'User ID'
		// 		)
		// 		->addColumn(
		// 			'comment_message',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		// 			\Magento\Framework\DB\Ddl\Table::MAX_TEXT_SIZE,
		// 			[
		// 				'nullable' => false
		// 			],
		// 			'Comment Message'
		// 		)
		// 		->addColumn(
		// 			'comment_status',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
		// 			null,
		// 			[
		// 				'nullable' => false,
		// 				'default' => 1
		// 			],
		// 			'Comment View Count'
		// 		)
		// 		->addColumn(
		// 			'comment_createdDate',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
		// 			null,
		// 			[
		// 				'nullable' => false,
		// 				'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
		// 			],
		// 			'Comment Created Date&Time'
		// 		)->addColumn(
		// 			'comment_updatedDate',
		// 			\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
		// 			null,
		// 			[
		// 				'nullable' => false,
		// 				'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
		// 			],
		// 			'Comment Updated Date&Time'
		// 		)->addIndex(
		// 			$setup->getIdxName(
		// 				$installer->getTable('emakina_blog_comments'),
		// 				['comment_id'],
		// 				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
		// 			),
		// 			['comment_id'],
		// 			\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
		// 		)->addForeignKey( // Add foreign key for table entity
		// 			$installer->getFkName(
		// 				'emakina_blog_comments', // New table
		// 				'post_id', // Column in New Table
		// 				'emakina_blog_posts', // Reference Table
		// 				'comment_id' // Column in Reference table
		// 			),
		// 			'post_id', // New table column
		// 			$installer->getTable('emakina_blog_posts'), // Reference Table
		// 			'post_id', // Reference Table Column
		// 			// When the parent is deleted, delete the row with foreign key
		// 			\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
		// 		)->setComment('Comment Table');
				
		// 	$installer->getConnection()->createTable($table);
		// }

		$installer->endSetup();
	}
}