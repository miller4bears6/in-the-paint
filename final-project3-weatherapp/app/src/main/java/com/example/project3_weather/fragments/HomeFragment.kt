package com.example.project3.fragments

import android.annotation.SuppressLint
import android.os.Build
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.annotation.RequiresApi
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.navigation.findNavController
import com.example.project3.R
import com.example.project3.WeatherApplication
import com.example.project3.databinding.FragmentHomeBinding
import com.example.project3.models.WeatherResponse
import com.example.project3.util.Constants
import com.example.project3.util.OtherUtils
import com.example.project3.viewmodels.MainViewModel
import com.example.project3.viewmodels.MainViewModelFactory
import kotlin.math.ceil
import kotlin.math.floor

class HomeFragment : Fragment() {

    private lateinit var mainViewModel: MainViewModel
    private lateinit var binding: FragmentHomeBinding

    @SuppressLint("SetTextI18n")
    @RequiresApi(Build.VERSION_CODES.O)
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {

        // Inflate the layout for this fragment
        binding = FragmentHomeBinding.inflate(layoutInflater)

        val repository = (activity?.application as WeatherApplication).weatherRepository

        mainViewModel =
            ViewModelProvider(this,
                MainViewModelFactory(repository)
            )[MainViewModel::class.java]


        // Set weatherResponse for the app
        mainViewModel.weathers.observe(requireActivity()) {
            Log.d("project3", it.toString())
            setupUI(it)
            Constants.storePreferenceWeather(it)
        }

        binding.llTemperature.setOnClickListener {
            it.findNavController().navigate(R.id.action_homeFragment_to_detailsFragment)
        }
        binding.ivWeatherLogo.setOnClickListener {
            it.findNavController().navigate(R.id.action_homeFragment_to_detailsFragment)
        }

        return binding.root

    }

    @SuppressLint("SetTextI18n")
    @RequiresApi(Build.VERSION_CODES.O)
    private fun setupUI(weatherResponse: WeatherResponse) {

        binding.tvWeatherDesc.text =
            weatherResponse.list[0].weather[0].description.replaceFirstChar { it.uppercaseChar() }
        binding.tvTemperature.text = weatherResponse.list[0].main.temp.toInt().toString()
        binding.tvLowestTemperature.text =
            floor(weatherResponse.list[0].main.tempMin).toInt().toString() + " °F"
        binding.tvHighestTemperature.text =
            ceil(weatherResponse.list[0].main.tempMax).toInt().toString() + " °F"

        binding.ivWeatherLogo.setBackgroundResource(
            OtherUtils.getWeatherIcon(weatherResponse.list[0].weather[0].id,
                weatherResponse.list[0].weather[0].icon))

    }

}