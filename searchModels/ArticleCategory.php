<?php

namespace common\modules\article\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\article\models\ArticleCategory as ArticleCategoryModel;

/**
 * ArticleCategory represents the model behind the search form about `common\modules\article\models\ArticleCategory`.
 */
class ArticleCategory extends ArticleCategoryModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'visible', 'featured', 'shown_on_menu', 'doindex', 'dofollow', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'creator_id', 'updater_id', 'image_id', 'parent_id'], 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'meta_keywords', 'meta_description', 'description', 'long_description', 'menu_label'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleCategoryModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'visible' => $this->visible,
            'featured' => $this->featured,
            'shown_on_menu' => $this->shown_on_menu,
            'doindex' => $this->doindex,
            'dofollow' => $this->dofollow,
            'type' => $this->type,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'image_id' => $this->image_id,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'heading', $this->heading])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'long_description', $this->long_description])
            ->andFilterWhere(['like', 'menu_label', $this->menu_label]);

        return $dataProvider;
    }
}
