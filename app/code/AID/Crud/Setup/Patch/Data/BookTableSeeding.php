<?php

namespace AID\Crud\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;

class BookTableSeeding implements DataPatchInterface
{
    const TABLE_NAME = 'books';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion()
    {
        return '1.0.0';
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();
        $setup = $this->moduleDataSetup;

        $data = [
            [
                'name' => 'Cú phạt đền',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện ngắn',
                'publish_year' => 1985
            ],
            [
                'name' => 'Trò chơi lãng mạn của tình yêu',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Tập truyện',
                'publish_year' => 1987
            ],
            [
                'name' => 'Bàn có năm chỗ ngồi',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 1987
            ],
            [
                'name' => 'Thằng quỷ nhỏ',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 1990
            ],
            [
                'name' => 'Hoa hồng xứ khác',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 1991
            ],
            [
                'name' => 'Trại hoa vàng',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 1994
            ],
            [
                'name' => 'Kính vạn hoa',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Bộ truyện',
                'publish_year' => 1995
            ],
            [
                'name' => 'Cho tôi xin 1 vé đi tuổi thơ',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện',
                'publish_year' => 2008
            ],
            [
                'name' => 'Có 2 con mèo ngồi bên cửa sổ',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 2012
            ],
            [
                'name' => 'Bảy bước tới mùa hè',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 2015
            ],
            [
                'name' => 'Con chó nhỏ mang giỏ hoa hồng',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 2016
            ],
            [
                'name' => 'Cảm ơn người lớn',
                'author' => 'Nguyễn Nhật Ánh',
                'genre' => 'Truyện dài',
                'publish_year' => 2018
            ],
        ];

        $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable(self::TABLE_NAME),
            ['name', 'author', 'genre', 'publish_year'],
            $data
        );

        $this->moduleDataSetup->endSetup();
    }
}

