package com.example.project3.util

import android.content.Context
import android.content.Context.MODE_PRIVATE
import android.content.SharedPreferences
import android.util.Log
import androidx.appcompat.app.AppCompatDelegate
import com.google.gson.Gson
import com.example.project3.models.WeatherResponse


object Constants {
    const val BASE_URL = "https://api.openweathermap.org/data/"
    const val APP_ID = "d782c3641dcc9cbcb8528dfb0245b3e4"
    const val UNITS = "imperial"
    var API_CALLED_ONCE_SUCCESSFULLY: Boolean = false
    var weatherResponse: WeatherResponse? = null
    private lateinit var prefWeather: SharedPreferences
    lateinit var prefAppSettings: SharedPreferences

    fun initializePreferences(context: Context) {
        prefWeather = context.getSharedPreferences(APP_ID, MODE_PRIVATE)
        prefAppSettings = context.getSharedPreferences(APP_ID, MODE_PRIVATE)

        if (prefAppSettings.getBoolean("NightMode", true))
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES)
        else
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO)
    }

    fun storePreferenceWeather(weatherResponse: WeatherResponse) {
        val gson = Gson()
        //Convert json object to string
        val json = gson.toJson(weatherResponse)
        //Store in the sharedPreference
        prefWeather.edit().putString("weather_response", json).apply()
        Log.i("MyTag", "$prefWeather")
    }
    fun getPreferenceWeather(): WeatherResponse? {
        val data = prefWeather.getString("weather_response", "")
        Log.i("MyTag", "$data")
        Log.i("MyTag", "${Gson().fromJson(data, WeatherResponse::class.java)}")
        return Gson().fromJson(data, WeatherResponse::class.java)
    }

}


