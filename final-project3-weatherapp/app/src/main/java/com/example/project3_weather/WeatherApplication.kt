package com.example.project3

import android.app.Application
import com.example.project3.api.RetrofitHelper
import com.example.project3.api.WeatherService
import com.example.project3.db.LocationDatabase
import com.example.project3.repository.WeatherRepository
import com.example.project3.util.Constants

class WeatherApplication: Application() {

    lateinit var weatherRepository: WeatherRepository

    override fun onCreate() {
        super.onCreate()

        // Shared preferences
        Constants.initializePreferences(this)

        initialize()
    }

    private fun initialize() {
        val weatherService = RetrofitHelper.getInstance().create(WeatherService::class.java)
        val database = LocationDatabase.getDatabase(applicationContext)
        weatherRepository = WeatherRepository(weatherService, database)
    }
}