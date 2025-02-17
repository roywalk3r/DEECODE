import {SignedIn, SignedOut, useAuth, useUser} from '@clerk/clerk-expo';
import {Link, Redirect} from 'expo-router';
import {SafeAreaView, ScrollView, View, StyleSheet, Image, TouchableOpacity} from 'react-native';
import { ThemedText } from '@/components/ThemedText';
import { StatusBar } from 'expo-status-bar';
import '../../global.css';
import React from 'react';
import { Dimensions } from 'react-native'
import uri from "ajv/lib/runtime/uri";
import { Button } from '~/components/ui/button';
import { Text } from '~/components/ui/text';
import {getStatusBarHeight} from "react-native-status-bar-height";
const StatusBarHeight = getStatusBarHeight();

export default function HomeScreen() {
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
     return (<SafeAreaView className="flex-1 bg-red-400" style={styles.view}>
            <ScrollView contentContainerStyle={{ flexGrow: 1,  alignItems: 'center' }}>
                <View className={"relative flex-1 p-4"}>

                <View className="flex flex-row justify-between w-full">
                    <View className="mb-4">
                        <Text className="font-bold text-left">
                            <Text className="text-4xl font-bold text-white">Film</Text>
                            <Text className="text-4xl font-bold text-red-500">Flix</Text>
                        </Text>
                    </View>
                    <TouchableOpacity>
                        <Link href="/(profile)">

                        {/*<Button className={"bg-red-500 shadow-lg"} onPress={handleSignOut}>*/}
                        {/*    <Text className="text-xl font-bold text-white ">Sign Out</Text>*/}
                        {/*</Button>*/}
                        <Image
                        accessibilityLabel="Search icon"
                         source={{
                             uri:`${user?.imageUrl}`,
                            }}
                           style={{ width: 40, height: 40, borderRadius: 50 }}
                        className={"rounded-full"}
                        />
                        </Link>
                    </TouchableOpacity>
                </View>

                    <View>
                        <Text>Hello, {user?.firstName}</Text>
                    </View>
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

