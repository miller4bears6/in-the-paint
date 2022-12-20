package com.example.project3.fragments

import android.annotation.SuppressLint
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import androidx.recyclerview.widget.LinearLayoutManager
import com.example.project3.R
import com.example.project3.WeatherApplication
import com.example.project3.adapters.DailyForecastAdapter
import com.example.project3.databinding.FragmentDetailsBinding
import com.example.project3.models.WeatherResponse
import com.example.project3.util.Constants
import com.example.project3.util.NetworkUtils
import com.example.project3.util.OtherUtils
import com.example.project3.viewmodels.MainViewModel
import com.example.project3.viewmodels.MainViewModelFactory


class DetailsFragment : Fragment() {

    private lateinit var mainViewModel: MainViewModel
    private lateinit var binding: FragmentDetailsBinding
    private lateinit var dailyAdapter: DailyForecastAdapter

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        // Inflate the layout for this fragment
        binding = FragmentDetailsBinding.inflate(layoutInflater)
        val repository = (activity?.application as WeatherApplication).weatherRepository

        mainViewModel =
            ViewModelProvider(this,
                MainViewModelFactory(repository)
            )[MainViewModel::class.java]

        if(!NetworkUtils.isNetworkAvailable(requireContext())) { // Internet Not Available
            if (Constants.getPreferenceWeather() != null) {
                setupUI(Constants.getPreferenceWeather()!!)
                Log.i("MyTag", Constants.getPreferenceWeather()!!.toString())
            }
        }

        // Set weatherResponse for the app
        mainViewModel.weathers.observe(requireActivity()) {
            Log.d("project3", it.toString())
            setupUI(it)
            Constants.weatherResponse = it
        }

        // Set Forecast visible when Forecast button clicked
        binding.tvForecastButton.setOnClickListener {
            binding.llDetails.visibility = View.INVISIBLE
            binding.llForecast.visibility = View.VISIBLE
            binding.tvForecastButton.setTextColor(
                ContextCompat.getColor(requireContext(), R.color.textColor))
            binding.tvDetailsButton.setTextColor(
                ContextCompat.getColor(requireContext(), R.color.translucent))
        }

        binding.tvDetailsButton.setOnClickListener {
            binding.llDetails.visibility = View.VISIBLE
            binding.llForecast.visibility = View.INVISIBLE
            binding.tvForecastButton.setTextColor(
                ContextCompat.getColor(requireContext(), R.color.translucent))
            binding.tvDetailsButton.setTextColor(
                ContextCompat.getColor(requireContext(), R.color.textColor))
        }

        return binding.root
    }

    @SuppressLint("SetTextI18n")
    private fun setupUI(weatherResponse: WeatherResponse) {

        binding.tvPrecipitation.text = "${weatherResponse.list[0].pop*100} %"

        binding.tvHumidity.text = "${weatherResponse.list[0].main.humidity} %"
        binding.tvVisibility.text =
            "${OtherUtils.roundOffDecimal(weatherResponse.list[0].visibility/1000.0)} mi"
        binding.tvCloudiness.text =
            when (weatherResponse.list[0].clouds.all) {
                in 0..20 -> "Lowest"
                in 21..40 -> "Low"
                in 41..60 -> "Medium"
                in 61..80 -> "High"
                else -> "Highest"
            }

        // Recycler Views
        if (isAdded) {

            dailyAdapter = DailyForecastAdapter(requireContext(), weatherResponse)
            binding.rvDailyForecast.adapter = dailyAdapter
            binding.rvDailyForecast.layoutManager =
                LinearLayoutManager(requireContext(), LinearLayoutManager.HORIZONTAL,false)
        }
    }

}