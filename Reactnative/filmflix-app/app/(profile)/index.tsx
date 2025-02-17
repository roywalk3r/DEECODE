import {SignedIn, SignedOut, useAuth, useUser} from '@clerk/clerk-expo';
import {Link, Redirect} from 'expo-router';
import {SafeAreaView, ScrollView, View, StyleSheet, Image, TouchableOpacity} from 'react-native';
import '../../global.css';
import React from 'react';
import { Button } from '~/components/ui/button';
import { Text } from '~/components/ui/text';
import {getStatusBarHeight} from "react-native-status-bar-height";
import Feather from "@expo/vector-icons/Feather";
const StatusBarHeight = getStatusBarHeight();

export default function Profile() {
    const { user } = useUser();
    const { isLoaded, isSignedIn, signOut } = useAuth();

    const handleSignOut = async () => {
        try {
            await signOut();
            console.log('Successfully signed out');
        } catch (error) {
            console.error('Error signing out:', error);
        }
    };

    if (isSignedIn==false) {
        return <Redirect href="/(auth)" />;
    }
    return (<SafeAreaView className="flex-1 bg-red-400 min-h-screen" style={styles.view}>
            <ScrollView contentContainerStyle={{ flexGrow: 1,  alignItems: 'center' }}>
                <View className={"relative flex-1 p-4 items-center w-full"}>

                    <View className="flex flex-row justify-between w-full">
                        <View className="mb-4">
                            <Text className="font-bold text-left">
                                <Text className="text-4xl font-bold text-white">Film</Text>
                                <Text className="text-4xl font-bold text-red-500">Flix</Text>
                            </Text>
                        </View>
                        <View>
                            <Button className={"bg-red-500 flex flex-row gap-4 rounded-xl shadow-2xl"} onPress={handleSignOut}>
                                <Feather name="log-out" size={24} color="white" />

                                <Text className="text-xl font-bold text-white ">Sign Out</Text>
                            </Button>
                        </View>

                    </View>

                    <View className="">
                        <Image
                            accessibilityLabel="Search icon"
                            source={{
                                uri:`${user?.imageUrl}`,
                            }}
                            style={{ width: 70, height: 70, borderRadius: 50, alignItems: 'center', display: 'flex', }}
                        />
                    </View>
                        <Text className={"text-center tex"}>Welcome,
                         <Text className={"text-red-400"}>
                            {user?.firstName}
                         </Text>
                        </Text>
                </View>

            </ScrollView>
        </SafeAreaView>


    );
}
const styles = StyleSheet.create({
    view: {
        marginTop: StatusBarHeight,
        flex: 1,
    },
});

