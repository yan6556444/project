package com.example.installation.utils;

public class Tug {

   private String longitude;
   private String  latitude;
   private String heave;
   private String heeling;
   private String trim;
   private String yaw;

    public String getLongitude() {
        return longitude;
    }

    public void setLongitude(String longitude) {
        this.longitude = longitude;
    }

    public String getLatitude() {
        return latitude;
    }

    public void setLatitude(String latitude) {
        this.latitude = latitude;
    }

    public String getHeave() {
        return heave;
    }

    public void setHeave(String heave) {
        this.heave = heave;
    }

    public String getHeeling() {
        return heeling;
    }

    public void setHeeling(String heeling) {
        this.heeling = heeling;
    }

    public String getTrim() {
        return trim;
    }

    public void setTrim(String trim) {
        this.trim = trim;
    }

    public String getYaw() {
        return yaw;
    }

    public void setYaw(String yaw) {
        this.yaw = yaw;
    }

    @Override
    public String toString() {
        return "Tug{" +
                "longitude='" + longitude + '\'' +
                ", latitude='" + latitude + '\'' +
                ", heave='" + heave + '\'' +
                ", heeling='" + heeling + '\'' +
                ", trim='" + trim + '\'' +
                ", yaw='" + yaw + '\'' +
                '}';
    }
}
