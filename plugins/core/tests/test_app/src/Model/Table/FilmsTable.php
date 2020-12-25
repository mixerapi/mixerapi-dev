<?php
declare(strict_types=1);

namespace MixerApi\Core\Test\App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class FilmsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('films');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Actors', [
            'through' => 'FilmActors',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('release_year')
            ->maxLength('release_year', 255)
            ->allowEmptyString('release_year');

        $validator
            ->nonNegativeInteger('rental_duration')
            ->notEmptyString('rental_duration');

        $validator
            ->decimal('rental_rate')
            ->notEmptyString('rental_rate');

        $validator
            ->nonNegativeInteger('length')
            ->allowEmptyString('length');

        $validator
            ->decimal('replacement_cost')
            ->notEmptyString('replacement_cost');

        $validator
            ->scalar('rating')
            ->maxLength('rating', 255)
            ->allowEmptyString('rating');

        $validator
            ->scalar('special_features')
            ->maxLength('special_features', 255)
            ->allowEmptyString('special_features');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['language_id'], 'Languages'));

        return $rules;
    }
}
