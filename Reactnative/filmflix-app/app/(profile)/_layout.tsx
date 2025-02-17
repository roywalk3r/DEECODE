import { Redirect, Stack } from 'expo-router';
import { useAuth } from '@clerk/clerk-expo';
import '../../global.css';
import { StatusBar } from 'expo-status-bar';
import React from 'react';

export default function ProfileLayoutRoute() {
    const { isSignedIn, isLoaded } = useAuth();



    return (
        <>
            <StatusBar style="auto" />
            <Stack
                screenOptions={{
                    headerShown: false,
                }}
            />
        </>
    );
}
