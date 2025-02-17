import {useSignIn} from '@clerk/clerk-expo'
import {Link, useRouter} from 'expo-router'
import {Image, ImageBackground, SafeAreaView, StyleSheet, TextInput, TouchableOpacity, View} from 'react-native'
import React from 'react'
import "../../global.css";
import {getStatusBarHeight} from "react-native-status-bar-height";
import { Button } from '~/components/ui/button';
import { Text } from '~/components/ui/text';
import {ThemedText} from "~/components/ThemedText";
import Feather from "@expo/vector-icons/Feather";
import {show} from "smooth-push";
import { ClerkAPIError } from '@clerk/types'
import {isClerkAPIResponseError} from "@clerk/clerk-js";

    const StatusBarHeight = getStatusBarHeight();
export default function SignIn() {
    const {signIn, setActive, isLoaded} = useSignIn()
    const router = useRouter()
    const [emailAddress, setEmailAddress] = React.useState('')
    const [password, setPassword] = React.useState('')
    const [showPassword, setShowPassword] = React.useState(false)
    const [errors, setErrors] = React.useState<ClerkAPIError[]>()

    // Handle the submission of the sign-in form
    const onSignInPress = React.useCallback(async () => {
        if (!isLoaded) return
        setErrors(undefined)

        // Start the sign-in process using the email and password provided
        try {
            const signInAttempt = await signIn.create({
                identifier: emailAddress,
                password,
            })

            // If sign-in process is complete, set the created session as active
            // and redirect the user
            if (signInAttempt.status === 'complete') {
                await setActive({session: signInAttempt.createdSessionId})
                router.replace('/')
            } else {
                // If the status isn't complete, check why. User might need to
                // complete further steps.
                console.error(JSON.stringify(signInAttempt, null, 2))
            }
        } catch (err:any) {
            if (isClerkAPIResponseError(err)) setErrors(err.errors)
            show({
                toastType: "error",
                message:err.longmessage || err.message,
                config: {
                    duration: 3000,
                },
            });
        }

    }, [isLoaded, emailAddress, password])

    //redirect to dash screen
    const GoHome = () => {
        router.push('/(auth)')
    }

    return (
         <SafeAreaView style={styles.view}>
            <View className="relative flex-1">
                <Image
                    className="absolute inset-0 w-full h-full object-cover"
                    source={{
                        uri: 'https://image.tmdb.org/t/p/original/9DHo5qXkG0titQmr2PF92N3aYYk.jpg',
                    }}
                />
                <View className="absolute inset-0 bg-black/50"></View>

                <View className="flex flex-col w-full items-center justify-around p-6 space-y-6 h-screen-safe">
                    <View>
                        <Link href={"/(auth)"} className="text-7xl font-bold text-center text-white">
                            <Text className="text-6xl font-bold text-white"> Film</Text>
                            <Text className="text-6xl font-bold text-red-500">Flix</Text>
                        </Link>
                    </View>

                    <View className="w-full p-y-4 flex gap-5 justify-between h-36">
                        <Text className="text-6xl text-center font-bold text-white">Sign In</Text>

                        <TextInput
                            autoCapitalize="none"
                            value={emailAddress}
                            placeholder="Enter email"
                            onChangeText={setEmailAddress}
                            placeholderTextColor="#6B7280"
                            className="w-full px-4 py-4 text-gray-800 bg-white rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        />

                        <View className="relative w-full justify-center">
                            <TextInput
                                value={password}
                                placeholder="Enter password"
                                secureTextEntry={!showPassword}
                                onChangeText={setPassword}
                                placeholderTextColor="#6B7280"
                                className="w-full px-4 py-4 text-gray-800 bg-white rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            />
                            <TouchableOpacity
                                className="absolute inset-y-0 right-4  flex justify-center"
                                onPress={() => setShowPassword(!showPassword)}
                            >
                                <Feather
                                    name={showPassword ? "eye-off" : "eye"}
                                    size={24}
                                    color="#6B7280"
                                />
                            </TouchableOpacity>
                        </View>

                        <Button className="bg-red-500 rounded-3xl hover:bg-gray-900" onPress={onSignInPress}>
                            <ThemedText>Sign In</ThemedText>
                        </Button>
                    </View>

                    <View className="flex flex-row items-center space-x-2">
                        <Text className="text-white">Don't have an account?</Text>
                        <Link href="/sign-up">
                            <Text className="text-red-500 font-medium">Sign up</Text>
                        </Link>
                    </View>
                </View>
            </View>
        </SafeAreaView>
    )
}

const styles = StyleSheet.create({
    view: {
        marginTop: StatusBarHeight,
        flex: 1,
    },
})