<?php
class EventCategory extends Model
{
// ...

public function events()
{
return $this->hasMany(Event::class, 'event_category_id');
}
}
