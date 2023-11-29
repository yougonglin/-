<?php
namespace supernova;
class GpsUtils {
    const x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    // π
    const pi = 3.1415926535897932384626;
    // 长半轴
    const a = 6378245.0;
    // 扁率
    const ee = 0.00669342162296594323;
 
    /**
     * 百度坐标系(BD-09)转WGS坐标
     *
     * @param float $lng 百度坐标纬度
     * @param float $lat 百度坐标经度
     * @return array WGS84坐标数组
     */
    public static function bd09ToWgs84 (float $lng, float $lat): array {
        $gcj = self::bd09ToGcj02($lng, $lat);
        return self::gcj02ToWgs84($gcj[0], $gcj[1]);
    }
 
    /**
     * WGS坐标转百度坐标系(BD-09)
     *
     * @param float $lng WGS84坐标系的经度
     * @param float $lat WGS84坐标系的纬度
     * @return array 百度坐标数组
     */
    public static function wgs84ToBd09 (float $lng, float $lat): array {
        $gcj = self::wgs84ToGcj02($lng, $lat);
        return self::gcj02ToBd09($gcj[0], $gcj[1]);
    }
 
    /**
     * 火星坐标系(GCJ-02)转百度坐标系(BD-09)
     *
     * @param float $lng 火星坐标经度
     * @param float $lat 火星坐标纬度
     * @return array 百度坐标数组
     * @see 谷歌、高德——>百度
     */
    public static function gcj02ToBd09 (float $lng, float $lat): array {
        $z = sqrt($lng * $lng + $lat * $lat) + 0.00002 * sin($lat * self::x_pi);
        $theta = atan2($lat, $lng) + 0.000003 * cos($lng * self::x_pi);
        $bd_lng = $z * cos($theta) + 0.0065;
        $bd_lat = $z * sin($theta) + 0.006;
        return [$bd_lng, $bd_lat];
    }
 
    /**
     * 百度坐标系(BD-09)转火星坐标系(GCJ-02)
     *
     * @param float $bd_lon 百度坐标纬度
     * @param float $bd_lat 百度坐标经度
     * @return array
     * @see 百度——>谷歌、高德
     */
    public static function bd09ToGcj02 (float $bd_lon, float $bd_lat): array {
        $x = $bd_lon - 0.0065;
        $y = $bd_lat - 0.006;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * self::x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * self::x_pi);
        $gg_lng = $z * cos($theta);
        $gg_lat = $z * sin($theta);
        return [$gg_lng, $gg_lat];
    }
 
    /**
     * WGS84转GCJ02(火星坐标系)
     *
     * @param float $lng WGS84坐标系的经度
     * @param float $lat WGS84坐标系的纬度
     * @return array 火星坐标数组
     */
    public static function wgs84ToGcj02 (float $lng, float $lat): array {
        $d_lat = self::transformlat($lng - 105.0, $lat - 35.0);
        $d_lng = self::transformlng($lng - 105.0, $lat - 35.0);
        $rad_lat = $lat / 180.0 * self::pi;
        $magic = sin($rad_lat);
        $magic = 1 - self::ee * $magic * $magic;
        $sqrt_magic = sqrt($magic);
        $d_lat = ($d_lat * 180.0) / ((self::a * (1 - self::ee)) / ($magic * $sqrt_magic) * self::pi);
        $d_lng = ($d_lng * 180.0) / (self::a / $sqrt_magic * cos($rad_lat) * self::pi);
        $mg_lat = $lat + $d_lat;
        $mg_lng = $lng + $d_lng;
        return [$mg_lng, $mg_lat];
    }
 
    /**
     * GCJ02(火星坐标系)转GPS84
     * @param float $lng 火星坐标系的经度
     * @param float $lat 火星坐标系纬度
     * @return array WGS84坐标数组
     */
    public static function gcj02ToWgs84 (float $lng, float $lat): array {
        $d_lat = self::transformlat($lng - 105.0, $lat - 35.0);
        $d_lng = self::transformlng($lng - 105.0, $lat - 35.0);
        $rad_lat = $lat / 180.0 * self::pi;
        $magic = sin($rad_lat);
        $magic = 1 - self::ee * $magic * $magic;
        $sqrt_magic = sqrt($magic);
        $d_lat = ($d_lat * 180.0) / ((self::a * (1 - self::ee)) / ($magic * $sqrt_magic) * self::pi);
        $d_lng = ($d_lng * 180.0) / (self::a / $sqrt_magic * cos($rad_lat) * self::pi);
        $mg_lat = $lat + $d_lat;
        $mg_lng = $lng + $d_lng;
        return [$lng * 2 - $mg_lng, $lat * 2 - $mg_lat];
    }
 
    /**
     * 纬度转换
     * @param float $lng
     * @param float $lat
     * @return float|int
     */
    public static function transFormLat (float $lng, float $lat): float {
        $ret = -100.0 + 2.0 * $lng + 3.0 * $lat + 0.2 * $lat * $lat + 0.1 * $lng * $lat + 0.2 * sqrt(abs($lng));
        $ret += (20.0 * sin(6.0 * $lng * self::pi) + 20.0 * sin(2.0 * $lng * self::pi)) * 2.0 / 3.0;
        $ret += (20.0 * sin($lat * self::pi) + 40.0 * sin($lat / 3.0 * self::pi)) * 2.0 / 3.0;
        $ret += (160.0 * sin($lat / 12.0 * self::pi) + 320 * sin($lat * self::pi / 30.0)) * 2.0 / 3.0;
        return $ret;
    }
 
    /**
     * 经度转换
     * @param float $lng
     * @param float $lat
     * @return float
     */
    public static function transFormLng (float $lng, float $lat): float {
        $ret = 300.0 + $lng + 2.0 * $lat + 0.1 * $lng * $lng + 0.1 * $lng * $lat + 0.1 * sqrt(abs($lng));
        $ret += (20.0 * sin(6.0 * $lng * self::pi) + 20.0 * sin(2.0 * $lng * self::pi)) * 2.0 / 3.0;
        $ret += (20.0 * sin($lng * self::pi) + 40.0 * sin($lng / 3.0 * self::pi)) * 2.0 / 3.0;
        $ret += (150.0 * sin($lng / 12.0 * self::pi) + 300.0 * sin($lng / 30.0 * self::pi)) * 2.0 / 3.0;
        return $ret;
    }
}