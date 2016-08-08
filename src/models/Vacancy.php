<?php
namespace Endouble\TheVacancyRepositoryProblem\models;

/**
 * A test vacancy model
 */
class Vacancy implements Model
{

    /**
     * The id of the vacancy
     *
     * @var integer
     */
    public $id;

    /**
     * The vacancy title
     *
     * @var string
     */
    public $title;

    /**
     * The vacancy content/description
     *
     * @var string
     */
    public $content;

    /**
     * The vacancy description
     *
     * @var string
     */
    public $description;
    
    public function __construct($id, $title, $content, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->description = $description;
    }
    
    public function toArray()
    {
        return [
                'id'=>$this->id,
                'title'=>$this->title,
                'content'=>$this->content,
                'description'=>$this->description
            ];
    }
    
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
