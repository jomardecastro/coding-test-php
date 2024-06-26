<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Like Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Article $article
 */
class Like extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'article_id' => true,
        'user' => true,
        'article' => true,
    ];

    protected $_validate = [
        'user_id' => [
            'uniqueCombination' => [
                'rule' => ['validateUnique', ['scope' => ['article_id']]],
                'provider' => 'table',
                'message' => 'You have already liked this article.'
            ]
        ]
    ];
}
