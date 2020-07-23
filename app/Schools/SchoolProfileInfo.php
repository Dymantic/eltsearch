<?php


namespace App\Schools;


class SchoolProfileInfo
{
    public string $name;
    public string $introduction;
    public int $area_id;
    public array $types;

    public function __construct($info)
    {
        $this->name = $info['name'];
        $this->introduction = $info['introduction'];
        $this->area_id = $info['area_id'];
        $this->types = $info['school_types'];
    }

    public function toArray(): array
    {
        return [
            'name'         => $this->name,
            'introduction' => $this->introduction,
            'area_id'      => $this->area_id,
            'type'         => $this->type,
        ];
    }
}
