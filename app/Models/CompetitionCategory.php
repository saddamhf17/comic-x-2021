<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionCategory extends Model
{
    use HasFactory;

    const STATUS_ACTIVE     = 1;
    const STATUS_DRAFT      = 0;
    const STATUS_DELETE     = -1;

    public function name()
    {
        $name = $this->competitionType->name;
        $level = $this->competitionLevel->name;

        $code = '';
        if($this->code != null) {
            $code = ' '.$this->code;
        }

        if($this->competitionLevel->name == 'Umum') {
            $level = "";
        }

        $gender = '';
        if($this->competition_gender_id != 'U') {
            $gender = ' '.$this->competition_gender_id;
        }

        return $name.' '.$level.$gender.$code;

    }

    public function code()
    {
        $name = $this->competitionType->code;
        $level = $this->competition_level_id;

        $code = '';

        if($this->code != null) {
            $code = '-'.$this->code;
        }

        if($this->competitionLevel->name == 'Sekolah' || $this->competitionType->id == '1'  || $this->competitionType->id == '6' || $this->competitionType->id == '7') {
            $level = "";
        } else {
            $level = '-'.$level;
        }

        $gender = '';
        if($this->competition_gender_id != 'U') {
            $gender = '-'.$this->competition_gender_id;
        }

        return $name.$level.$gender.$code;

    }

    public function scopeIsNotDeleted($query)
    {
        return $query->where('status', '!=', static::STATUS_DELETE);
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }

    public function competitionType()
    {
        return $this->belongsTo('App\Models\CompetitionType');
    }

    public function competitionLevel()
    {
        return $this->belongsTo('App\Models\CompetitionLevel');
    }

    public function competitionGender()
    {
        return $this->belongsTo('App\Models\CompetitionGender');
    }

    public function competitor()
    {
        return $this->hasMany('App\Models\Competitor')->where('competitor_status','>',0);
    }

    public function scopeIsIndividu($query)
    {
        return $query->where('isTeam', '!=', 1);
    }

    public function scopeIsKelompok($query)
    {
        return $query->where('isTeam', '=', 1);
    }
    public function isTeam()
    {
        $msg = "";

        if($this->member > 1) {
            $msg = "Ya";
        } else {
            $msg = "Tidak";
        }

        return $msg;
    }


    public function minKelas()
    {
        $min = explode(',', $this->class);
        return $min[0];
    }

    public function maxKelas()
    {
        $max = explode(',', $this->class);
        return end($max);
    }

}
