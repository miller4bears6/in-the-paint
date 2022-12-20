package com.example.project3.util

import com.example.project3.models.LocationEntity

interface ToolbarVisibilityHandler {
    fun showToolbar()

    fun hideToolbar()

    fun insertRecord(locationEntity: LocationEntity)
}