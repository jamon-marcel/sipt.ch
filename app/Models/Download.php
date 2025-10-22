<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Download extends Model
{
	protected $fillable = [
		'title',
		'file',
		'order',
		'is_published',
	];

	protected $casts = [
		'is_published' => 'integer',
	];

	protected $appends = [
		'file_name',
		'file_type',
		'file_size',
		'formatted_file_size',
		'file_path',
	];

	public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1);
	}

	public function getFilePathAttribute()
	{
		if (!$this->file) {
			return null;
		}

		return 'uploads/' . $this->file;
	}

	public function getFileNameAttribute()
	{
		if (!$this->file) {
			return null;
		}

		// Extract original filename (remove prefix and unique ID)
		return preg_replace('/^sipt-[a-z0-9]+_/', '', $this->file);
	}

	public function getFileTypeAttribute()
	{
		if (!$this->file) {
			return null;
		}

		return pathinfo($this->file, PATHINFO_EXTENSION);
	}

	public function getFileSizeAttribute()
	{
		if (!$this->file) {
			return null;
		}

		$filePath = 'uploads/' . $this->file;
		if (!Storage::disk('public')->exists($filePath)) {
			return null;
		}

		return Storage::disk('public')->size($filePath);
	}

	public function getFormattedFileSizeAttribute()
	{
		$size = $this->file_size;

		if (!$size) {
			return 'N/A';
		}

		$units = ['B', 'KB', 'MB', 'GB'];
		$i = 0;

		while ($size >= 1024 && $i < count($units) - 1) {
			$size /= 1024;
			$i++;
		}

		return round($size, 1) . $units[$i];
	}
}
