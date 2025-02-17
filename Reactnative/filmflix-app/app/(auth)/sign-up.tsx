import * as React from 'react';
import {Image, SafeAreaView, StyleSheet, TextInput, TouchableOpacity, View} from 'react-native';
import { useSignUp } from '@clerk/clerk-expo';
import {Link, useRouter} from 'expo-router';
import { ThemedText } from '@/components/ThemedText';
import {getStatusBarHeight} from "react-native-status-bar-height";
import { Button } from '~/components/ui/button';
import { Text } from '~/components/ui/text';
import Feather from '@expo/vector-icons/Feather';

const StatusBarHeight = getStatusBarHeight();
export default function SignUpScreen() {
    const { isLoaded, signUp, setActive } = useSignUp();
    const router = useRouter();

    const [emailAddress, setEmailAddress] = React.useState('');
    const [password, setPassword] = React.useState('');
    const [pendingVerification, setPendingVerification] = React.useState(false);
    const [code, setCode] = React.useState('');
    const [showPassword, setShowPassword] = React.useState(false)

    const onSignUpPress = async () => {
        if (!isLoaded) return;

        try {
            await signUp.create({
                emailAddress,
                password,
            });

            await signUp.prepareEmailAddressVerification({ strategy: 'email_code' });
            setPendingVerification(true);
        } catch (err) {
            console.error(JSON.stringify(err, null, 2));
        }
    };

    const onVerifyPress = async () => {
        if (!isLoaded) return;

        try {
            const signUpAttempt = await signUp.attemptEmailAddressVerification({ code });

            if (signUpAttempt.status === 'complete') {
                await setActive({ session: signUpAttempt.createdSessionId });
                router.replace('/');
            } else {
                console.error(JSON.stringify(signUpAttempt, null, 2));
            }
        } catch (err) {
            console.error(JSON.stringify(err, null, 2));
        }
    };

    if (pendingVerification) {
        return (
            <View className="flex flex-col items-center justify-center p-6 space-y-4 bg-gray-100 min-h-screen">
                <ThemedText className="text-lg font-bold text-center text-gray-800">Verify your email</ThemedText>
                <TextInput
                    value={code}
                    placeholder="Enter your verification code"
                    onChangeText={setCode}
                    className="w-full p-3 bg-white border border-gray-300 rounded-md text-black"
                />
                <Button  onPress={onVerifyPress} className="mt-4 bg-red-400 rounded-md" />
                <Text>Verify</Text>
            </View>
        );
    }

    return (
        <SafeAreaView style={styles.view} >
            <View className="relative flex-1">
                <Image
                    className="absolute inset-0 w-full h-full object-cover"
                    source={{
                        uri: 'https://image.tmdb.org/t/p/original/h94AAQIJ8NMRutCTTWHF6Yg5vjz.jpg',
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
                        <Text className="text-6xl text-center font-bold text-white">Sign Up</Text>
                        <TextInput
                            autoCapitalize="none"
                            value={emailAddress}
                            placeholder="Enter email"
                            onChangeText={setEmailAddress}
                            placeholderTextColor="#6B7280"
                            className="w-full px-4 py-4 text-gray-800 bg-white  rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200"
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
                        <Button
                            onPress={onSignUpPress}
                            className="w-full p-3 mt-6 bg-red-400  rounded-3xl"
                        >
                            <Text>Continue</Text>
                        </Button>
                    </View>
                    <View className="flex flex-row items-center space-x-2">
                        <Text className="text-white">Already have an account?</Text>
                        <Link href="/sign-in">
                            <Text className="text-red-500 font-medium"> Sign in</Text>
                        </Link>
                    </View>
                </View>
            </View>
        </SafeAreaView>

    // <SafeAreaView style={styles.view} >
    //         <View className="relative flex-1">
    //     <View className="flex w-full flex-col justify-center p-6  h-screen-safe">
    //             <Image
    //                 className="absolute inset-0 w-full h-full object-cover"
    //                 source={{
    //                     uri: 'https://image.tmdb.org/t/p/original/9DHo5qXkG0titQmr2PF92N3aYYk.jpg',
    //                 }}
    //             />
    //             <View className="absolute inset-0 bg-black/50"></View>
    //         <View>
    //             <Text className="text-7xl font-bold text-center text-white">
    //                 <Text className="text-6xl font-bold text-white"> Film</Text>
    //                 <Text className="text-6xl font-bold text-red-500">Flix</Text>
    //             </Text>
    //         </View>
    //         <Text className="text-4xl font-bold text-center text-gray-800">Sign Up</Text>
    //
    //         <TextInput
    //             autoCapitalize="none"
    //             value={emailAddress}
    //             placeholder="Enter email"
    //             onChangeText={setEmailAddress}
    //             className="w-full px-3 py-4 mt-4 bg-white border border-gray-300 rounded-3xl text-black"
    //         />
    //
    //         <TextInput
    //             value={password}
    //             placeholder="Enter password"
    //             secureTextEntry
    //             onChangeText={setPassword}
    //             className="w-full px-3 py-4 mt-4 bg-white border border-gray-300 rounded-3xl text-black"
    //         />
    //         <Button
    //             onPress={onSignUpPress}
    //             className="w-full p-3 mt-6 bg-red-400  rounded-3xl"
    //         >
    //             <Text>Continue</Text>
    //         </Button>
    //     </View>
    //     </View>
    //     </SafeAreaView>

    );
}

const styles = StyleSheet.create({
    view: {
        marginTop: StatusBarHeight,
        flex: 1,
    },
})