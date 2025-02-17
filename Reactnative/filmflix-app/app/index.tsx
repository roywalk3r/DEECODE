import React from 'react';
import { SafeAreaView, Text, StyleSheet, TouchableOpacity } from 'react-native';
import {useAuth, useUser} from '@clerk/clerk-expo';
import {Redirect} from "expo-router";

export default function HomePage() {
    const { isLoaded, isSignedIn, userId, signOut } = useAuth();
    const { user } = useUser();

    const handleSignOut = async () => {
        try {
            await signOut();
            console.log('Successfully signed out');
        } catch (error) {
            console.error('Error signing out:', error);
        }
    };
console.log(user);
    if (!isLoaded) {
        return (
            <SafeAreaView style={styles.container}>
                <Text style={styles.text}>Loading...</Text>
            </SafeAreaView>
        );
    }

    return (
        <SafeAreaView style={styles.container}>
            {isSignedIn ? (
                <>
                    <Text style={styles.text}>Welcome, User ID: {}</Text>
                    <TouchableOpacity style={styles.button} onPress={handleSignOut}>
                        <Text style={styles.buttonText}>Sign Out</Text>
                    </TouchableOpacity>
                </>
            ) : (
                <Redirect  href={"/(auth)"} />
            )}
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#000',
    },
    text: {
        color: '#fff',
        fontSize: 18,
        marginBottom: 20,
    },
    button: {
        backgroundColor: '#ff0000',
        paddingVertical: 10,
        paddingHorizontal: 20,
        borderRadius: 8,
    },
    buttonText: {
        color: '#fff',
        fontSize: 16,
        fontWeight: 'bold',
    },
});
