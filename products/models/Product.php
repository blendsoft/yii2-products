<?php

namespace app\modules\products\models;

use app\components\behaviors\HasImages;
use app\components\behaviors\HasUser;
use app\components\behaviors\ImageColumn;
use app\components\behaviors\PermissionsBehavior;
use app\helpers\Filesystem;
use app\modules\shop\models\Buys;
use Comodojo\Zip\Zip;
use Intervention\Image\ImageManager;
use RarArchiver;
use RuntimeException;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\i18n\Formatter;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $media_type_id
 * @property integer $created
 * @property integer $updated
 * @property int|string user_id
 */
class Product extends ActiveRecord {

    const TYPE_MODEL_3D = 1;
    const STATUS_NOT_PUBLISHED = 0;
    const STATUS_FOR_PUBLISHED = 1;
    const STATUS_PUBLISHED = 2;

    public $mainImage;
    public $tmpImages;
    public $tmpCategories;
    public $pattributes_geometry, $pattributes_polygons, $pattributes_vertices, $pattributes_textures, $pattributes_pbl_textures, $pattributes_materials,
            $pattributes_rigged, $pattributes_animated, $pattributes_uv_mapped, $pattributes_unwrapped_uvs, $pattributes_game_ready;
    public $tmpSoftwares;
    public $tmpFormats;
    public $tmpEngines;
    public $keyword;
    public $boughtUser_id;
    public $salesUser_id;
    public static $geometries = [
        1 => 'Polygnal',
        2 => 'NURBS',
        3 => 'Subdivision',
        4 => 'Unknown',
        5 => 'Polygonal Quads/Tris',
        6 => 'Polygonal Quads only',
        7 => 'Polygonal Tris only',
        8 => 'Polygonal Ngons used',
    ];
    public static $unwrapped_uvs = [
        1 => 'Unknown',
        2 => 'Yes, non-overlapping',
        3 => 'Yes, overlapping',
        4 => 'Unknown',
        5 => 'Mixed',
        6 => 'No',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'product';
    }

    public function behaviors() {
        return
                [
                    [
                        'class' => TimestampBehavior::className(),
                        'createdAtAttribute' => 'created',
                        'updatedAtAttribute' => 'updated',
                    ],
                    [
                        'class' => SluggableBehavior::className(),
                        'attribute' => 'name',
                    ],
                    [
                        'class' => HasImages::className(),
                    ],
                    [
                        'class' => HasUser::className(),
                    ],
                    [
                        'class' => ImageColumn::className(),
                    ],
                    [
                        'class' => PermissionsBehavior::className(),
                    ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['media_type_id', 'created', 'updated'], 'integer'],
            [['pattributes_polygons', 'pattributes_unwrapped_uvs'], 'required'],
            [['tmpImages', 'mainImage', 'tmpCategories', 'pattributes_polygons', 'pattributes_textures', 'pattributes_pbl_textures',
            'pattributes_materials', 'pattributes_rigged', 'pattributes_game_ready',
            'pattributes_animated', 'pattributes_uv_mapped', 'description', 'promoted', 'price_off', 'published'], 'safe'],
            [['tmpSoftwares', 'tmpFormats', 'tmpEngines', 'sources', 'changes'], 'safe'],
            [['tmpImages', 'mainImage'], 'file', 'extensions' => 'jpg, gif, png'],
            [['sources'], 'file', 'extensions' => 'zip, rar'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'media_type_id' => Yii::t('app', 'Media Type'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'pattributes_geometry' => Yii::t('app', 'Geometry'),
            'pattributes_polygons' => Yii::t('app', 'Polygons'),
            'pattributes_vertices' => Yii::t('app', 'Vertices'),
            'pattributes_textures' => Yii::t('app', 'Textures'),
            'pattributes_pbl_textures' => Yii::t('app', 'PBL Textures'),
            'pattributes_materials' => Yii::t('app', 'Materials'),
            'pattributes_rigged' => Yii::t('app', 'Rigged'),
            'pattributes_animated' => Yii::t('app', 'Animated'),
            'pattributes_uv_mapped' => Yii::t('app', 'UV Mapped'),
            'pattributes_unwrapped_uvs' => Yii::t('app', 'Unwrapped UVs'),
            'tmpSoftwares' => Yii::t('app', 'Software'),
            'tmpEngines' => Yii::t('app', 'Game engines'),
            'tmpFormats' => Yii::t('app', 'Format'),
            'promoted' => Yii::t('app', 'Promoted'),
            'price_off' => Yii::t('app', 'Price Off (%)'),
            'published' => Yii::t('app', 'Published'),
            'changes' => Yii::t('app', 'Changes'),
            'pattributes_game_ready' => Yii::t('app', 'Game ready'),
            'user_id' => Yii::t('app', 'Owner'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProductQuery(get_called_class());
    }

    public function getProductAttributesByCategory() {
        $cats = $this->categories;
        $attrs = [];
        foreach ($cats as $cat) {
            if (null != $cat->product_attributes && is_array($cat->product_attributes)) {
                $attrs = ArrayHelper::merge($attrs, $cat->product_attributes);
            }
        }
        return $attrs;
    }

    public function getProductAttributesValuesByCategory() {

        $attrsArray = $this->getProductAttributesByCategory();
        $arr = [];
        $attrs = ProductAttribute::findAll($attrsArray);

        foreach ($attrs as $key => $attr) {
            $pa = ProductAttributes::findOne(['attribute_id' => $attr->id, 'product_id' => $this->id]);
            if (null != $pa) {
                $arr[] = $pa;
            } else {
                $pa = new ProductAttributes();
                $pa->attribute_id = $attr->id;
                $pa->product_id = $this->id;
                $arr[] = $pa;
            }
        }
        return $arr;
    }

    public function getBuys() {
        return $this->hasMany(Buys::className(), ['product_id' => 'id']);
    }

    public function getTypeAttributes() {
        return $this->hasMany(ProductAttribute::className(), ['product_type_id' => 'media_type_id']);
    }

    public function getProductAttributes() {
        return $this->hasMany(ProductAttributes::className(), ['product_id' => 'id']);
    }

    public function getCategories() {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
                        ->viaTable('product_categories', ['product_id' => 'id']);
    }

    public function getSoftwares() {
        return $this->hasMany(ProductCompat::className(), ['id' => 'product_compat_id'])
                        ->viaTable('product_compats', ['product_id' => 'id']);
    }

    public function getFormats() {
        return $this->hasMany(ProductFileFormat::className(), ['id' => 'product_format_id'])
                        ->viaTable('product_file_formats', ['product_id' => 'id']);
    }

    public function getEngines() {
        return $this->hasMany(ProductGameEngine::className(), ['id' => 'product_game_engine_id'])
                        ->viaTable('product_game_engines', ['product_id' => 'id']);
    }

    public function getEngineVersions() {
        return $this->hasMany(ProductGameEngines::className(), ['product_id' => 'id']);
    }

    public function getImages() {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    public function getMovies() {
        return $this->hasMany(ProductMovie::className(), ['product_id' => 'id']);
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription($limit = null) {
        if ($limit != null) {
            return StringHelper::truncateWords(strip_tags($this->description), $limit);
        } else {
            return $this->description;
        }
    }

    public function getNameToView() {
        return Html::a($this->getName(), ['/products/product/view', 'id' => $this->id]);
    }

    public function getUri() {
        return Url::to(['/products/product/view', 'id' => $this->id]);
    }

    public function getPrice() {
        if (empty($this->price_off)) {
            return $this->price;
        } else {
            return $this->getPromoPrice();
        }
    }

    public function getPriceOff() {
        return $this->price_off;
    }

    public function getOrgPrice() {
        return $this->price;
    }

    public function getPromoPrice() {
        return $this->price - ($this->price * ($this->price_off / 100));
    }

    public function getPriceWithOff() {
        if (empty($this->price_off)) {
            return $this->getPrice();
        } else {
            return '<p class="org-price"><s>' . $this->getOrgPrice() . '</s></p>' . '<p class="off-price">' . $this->getPriceOff() . '</p>';
        }
    }

    public function getCurrencyPrice() {
        return Yii::$app->formatter->asCurrency($this->getPrice(), Yii::$app->params['currency']);
    }

    public function getCurrencyPriceWithOff() {
        if (empty($this->price_off)) {
            return '<p class="org-price">&nbsp;</p><p class="off-price">' . Yii::$app->formatter->asCurrency($this->getOrgPrice(), Yii::$app->params['currency']) . '</p>';
        } else {
            return '<p class="org-price"><s>'
                    . Yii::$app->formatter->asCurrency($this->getOrgPrice(), Yii::$app->params['currency'])
                    . '</s></p>' . '<p class="off-price">'
                    . Yii::$app->formatter->asCurrency($this->getPromoPrice(), Yii::$app->params['currency']) . '</p>';
        }
    }

    public function getCurrencyPriceWithOff2() {
        if (empty($this->price_off)) {
            return '<p class="off-price">' . Yii::$app->formatter->asCurrency($this->getOrgPrice(), Yii::$app->params['currency']) . '</p>';
        } else {
            return '<p class="org-price"><s>'
                    . Yii::$app->formatter->asCurrency($this->getOrgPrice(), Yii::$app->params['currency'])
                    . '</s></p>' . '<p class="off-price">'
                    . Yii::$app->formatter->asCurrency($this->getPromoPrice(), Yii::$app->params['currency']) . '</p>';
        }
    }

    public function getCurrency() {
        return '$';
    }

    public function getSoftwareString() {
        $s = '';
        foreach ($this->softwares as $software) {
            $s .= $software->name . ', ';
        }
        return $s;
    }

    public function getEnginesString() {
        $s = '';
        foreach ($this->engineVersions as $e) {
            $s .= $e->getEngineName() . ' ' . $e->getVersion() . ', ';
        }
        return $s;
    }

    public function getFormatsString() {
        $s = '';
        foreach ($this->formats as $format) {
            $s .= $format->name . ', ';
        }
        return $s;
    }

    public function getSourceFilesList() {
        $files = unserialize($this->sources_files);

        $html = '';

        if (is_array($files)) {

            foreach ($files as $file) {
                $html .= Html::tag('li', '<i class="fa-li fa fa-check-square"></i>' . $file);
            }
            $html = Html::tag('ul', $html, ['class' => 'fa-ul']);
        }


        return $html;
    }

    public function getPublished() {
        $formater = new Formatter();
        return $formater->asDate($this->created);
    }

    public function getAttributeByName($name) {
        return $this->{'pattributes_' . $name};
    }

    public function getBoolAttributeByName($name) {
        $f = new Formatter();
        return $f->asBoolean($this->{'pattributes_' . $name});
    }

    public function getGeometry() {
        if (isset(Product::$geometries[$this->pattributes_geometry])) {
            return Product::$geometries[$this->pattributes_geometry];
        }
    }

    public function getUnwrappedUVs() {
        if (isset(Product::$unwrapped_uvs[$this->pattributes_unwrapped_uvs])) {
            return Product::$unwrapped_uvs[$this->pattributes_unwrapped_uvs];
        }
    }

    public function getSourcesTagArray() {
        $arr = [];
        if (empty($this->sources) === false) {
            $arr[] = '<div class="file-object"><div class="file-preview-other"><span class="file-icon-4x"><i class="glyphicon glyphicon-file"></i></span></div></div>';
        }
        return $arr;
    }

    public function getSourcesPreviewConf() {

        $arr = [];
        if (empty($this->sources) === false) {
            $arr[] = [
                'showZoom' => false,
                'showDrag' => false,
                'caption' => $this->sources,
                'width' => '120px',
                'type' => 'other',
                'url' => Url::to(['/products/product/delete-source', 'id' => $this->id]),
                'key' => $this->id,
                'extra' => ['id' => $this->id]
            ];
        }
        return $arr;
    }

    public function getAddCartButton() {

        if ($this->isBought() === true) {
            $html = Html::a('<span class="ladda-label">' . Yii::t('app', 'Download') . '</span><span class="ladda-spinner"></span>', ['/products/product/download-source', 'id' => $this->id], [
                        'class' => 'btn add-to-cart ladda-button btn-warning',
                        'data-product' => $this->id
            ]);
        } else {
            $html = Html::button('<span class="ladda-label">' . Yii::t('app', 'Add to cart') . '</span><span class="ladda-spinner"></span>', [
                        'class' => 'btn add-to-cart ladda-button btn-warning',
                        'data-product' => $this->id
            ]);
        }
        return $html;
    }

    public function getSourceFilePath() {
        $slug = Inflector::slug(self::className(), '_');
        $fileNameOut = $this->sources;
        $fileOut = Yii::getAlias('@webroot/uploads/' . $slug . '/sources/' . $fileNameOut);
        return $fileOut;
    }

    public function updateProductAttributes() {

        $attrs = $this->typeAttributes;
        foreach ($attrs as $attr) {

            $value = $this->{'pattributes_' . $attr->name_id};
            $ptype = ProductAttributes::find()->where(['product_id' => $this->id, 'attribute_id' => $attr->id])->one();


            if (isset($ptype) === false) {
                $ptype = new ProductAttributes();
                $ptype->product_id = $this->id;
                $ptype->attribute_id = $attr->id;
            }

            if (null !== $value) {
                $ptype->value_string = $value;
                $ptype->save(false);
            }
        }

        //exit(0);
    }

    public function createCategoryArray() {
        //fix to array        
        $cats = ProductCategory::findAll(explode(',', $this->tmpCategories));
        $catArray = [];
        foreach ($cats as $cat) {
            $catArray[] = $cat->id;
            $parents = $cat->parents()->all();
            foreach ($parents as $parent) {
                $catArray[] = $parent->id;
            }
        }
        return array_unique($catArray);
    }

    public function loadProductAttributes() {
        $attrs = $this->productAttributes;
        foreach ($attrs as $attr) {
            $this->{'pattributes_' . $attr->typeName} = $attr->value_string;
        }
    }

    public function isBought() {
        $model = Buys::findOne(['product_id' => $this->id, 'user_id' => Yii::$app->getUser()->id]);
        if (null != $model) {
            return true;
        } else {
            return false;
        }
    }

    public function isNotPublished() {
        if ($this->published === Product::STATUS_NOT_PUBLISHED) {
            return true;
        } else {
            return false;
        }
    }

    public function isWaitingPublished() {
        if ($this->published === Product::STATUS_FOR_PUBLISHED) {
            return true;
        } else {
            return false;
        }
    }

    public function isPublished() {
        if ($this->published === Product::STATUS_PUBLISHED) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadMain() {

        $slug = Inflector::slug(self::className(), '_');
        $path = Yii::getAlias('@webroot/uploads/' . $slug);
        Filesystem::checkCreateDirectory($path);
        $file = $this->image->tempName;

        $fileOut = Yii::getAlias('@webroot/uploads/' . $slug . '/org_' . $this->id . '.' . 'jpg');
        $manager = new ImageManager(['driver' => 'gd', 'cache' => ['path' => 'cache/']]);
        $manager->make($file)->save($fileOut, 100);
        $this->image = $this->id . '.jpg';

        return true;
    }

    public function uploadSource() {

        $slug = Inflector::slug(self::className(), '_');

        $path = Yii::getAlias('@webroot/uploads/' . $slug . '/sources/');
        Filesystem::checkCreateDirectory($path);
        $fileNameOut = Inflector::slug($this->name, '_') . '.' . $this->sources->extension;
        $fileOut = Yii::getAlias('@webroot/uploads/' . $slug . '/sources/' . $fileNameOut);
        $this->sources->saveAs($fileOut);
        $this->sources = $fileNameOut;

        try {
            $rar = new RarArchiver($fileOut, RarArchiver::CREATE);
        } catch (RuntimeException $e) {
            //echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        if (isset($rar) && (bool) $rar->isRar() === true) {
            $files = $rar->getFileList();
            $this->sources_files = serialize($files);
        } else {
            if (Zip::check($fileOut)) {
                $zip = Zip::open($fileOut);
                $files = $zip->listFiles();
                $this->sources_files = serialize($files);
            }
        }

        return true;
    }

    public function saveProductAttributes($post) {

        foreach ($post as $key => $row) {
            $pa = ProductAttributes::findOne(['attribute_id' => $key, 'product_id' => $this->id]);
            if (null != $pa) {
                $pa->setAttributes($row);
            } else {
                $pa = new ProductAttributes();
                $pa->setAttributes($row);
                $pa->attribute_id = $key;
                $pa->product_id = $this->id;
            }

            $pa->save(false);
        }
    }

}
