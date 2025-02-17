import { Redirect, Stack } from 'expo-router';
import { useAuth } from '@clerk/clerk-expo';
import '../../global.css';
import { StatusBar } from 'expo-status-bar';
import React from 'react';

export default function AuthRoutesLayout() {
    const { isSignedIn, isLoaded } = useAuth();

    if (isLoaded && isSignedIn === true) {
        return <Redirect href="/(home)" />;
    }


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
