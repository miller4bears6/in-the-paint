package com.example.project3.viewmodels

import android.content.Context
import android.util.Log
import android.widget.Toast
import androidx.lifecycle.LiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.project3.models.LocationEntity
import com.example.project3.models.WeatherResponse
import com.example.project3.repository.WeatherRepository
import com.example.project3.util.Constants
import com.example.project3.util.NetworkUtils
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

class MainViewModel (private val repository: WeatherRepository): ViewModel() {

    val locations = repository.locations
    val primaryLocation = repository.primaryLocation

    val weathers: LiveData<WeatherResponse>
    get() = repository.weather

    fun getAPIData(context: Context, lat: Double, lon: Double) {
        if (NetworkUtils.isNetworkAvailable(context)) {
            Log.i("MyTag", "API Called")
            viewModelScope.launch(Dispatchers.IO) {
                repository.getWeather(lat, lon, Constants.UNITS, Constants.APP_ID)
            }
            Constants.API_CALLED_ONCE_SUCCESSFULLY = true
        } else {
            Toast.makeText(context, "Please connect to a network", Toast.LENGTH_LONG).show()
        }
    }

    fun insertLocation(locationEntity: LocationEntity) = viewModelScope.launch {
        repository.insert(locationEntity)
    }
    fun deleteLocation(locationEntity: LocationEntity) = viewModelScope.launch {
        repository.delete(locationEntity)
    }
    fun updateLocation(locationEntity: LocationEntity) = viewModelScope.launch {
        repository.update(locationEntity)
    }
    fun updateLocationToNotPrimary() = viewModelScope.launch {
        repository.updateLocationToNotPrimary()
    }

}