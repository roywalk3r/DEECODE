import React from 'react';
import {
    SafeAreaView,
    View,
    StyleSheet,
    Image,
    Dimensions,
    TouchableOpacity,
} from 'react-native';
import { SignedOut, useOAuth } from '@clerk/clerk-expo';
import { Link } from 'expo-router';
import AntDesign from "@expo/vector-icons/AntDesign";
import { Button } from '~/components/ui/button';
import { Text } from '~/components/ui/text';
import { ThemedText } from '@/components/ThemedText';
import * as Linking from "expo-linking";
import * as WebBrowser from 'expo-web-browser';
import { getStatusBarHeight } from 'react-native-status-bar-height';

WebBrowser.maybeCompleteAuthSession();
const StatusBarHeight = getStatusBarHeight();

export const useWarmUpBrowser = () => {
    React.useEffect(() => {
        void WebBrowser.warmUpAsync();
        return () => {
            void WebBrowser.coolDownAsync();
        };
    }, []);
};

export default function Page() {
    useWarmUpBrowser();
    const { startOAuthFlow } = useOAuth({ strategy: 'oauth_google' });

    const GoogleAuth = React.useCallback(async () => {
        try {
            const { createdSessionId, setActive } = await startOAuthFlow({
                redirectUrl: Linking.createURL('/(home)', { scheme: 'myapp' }),
            });

            if (createdSessionId) {
                setActive?.({ session: createdSessionId });
            }
        } catch (err) {
            console.error('Google Auth Error:', err);
        }
    }, [startOAuthFlow]);

    return (
        <SafeAreaView style={styles.view}>
            <View className="relative flex-1">
                <Image
                    className="absolute inset-0 w-full h-full object-cover"
                    source={{
                        uri: 'https://image.tmdb.org/t/p/original/dST2cvC7nBMMmLSONfmSo3drIJI.jpg',
                    }}
                />
                <View className="absolute inset-0 bg-black/50" />

                <View className="relative flex flex-col items-center justify-evenly h-full px-4 space-y-6">
                    <View>
                        <Text className="text-7xl font-bold text-center text-white">
                            Welcome to
                            <Text className="text-6xl font-bold text-white"> Film</Text>
                            <Text className="text-6xl font-bold text-red-500">Flix</Text>
                        </Text>
                        <Text className="text-2xl text-center text-gray-300">
                            Discover the latest movies and TV shows
                        </Text>
                    </View>

                    <SignedOut>
                        <View className="space-y-4 w-full justify-between gap-4 h-36">
                            <Button className="bg-red-500 hover:bg-red-600 rounded-xl">
                                <Link href="/(auth)/sign-in">
                                    <ThemedText>Sign In</ThemedText>
                                </Link>
                            </Button>
                            <Button className="bg-gray-800 hover:bg-gray-900 rounded-xl">
                                <Link href="/(auth)/sign-up">
                                    <ThemedText>Sign Up</ThemedText>
                                </Link>
                            </Button>
                            <Text className="text-center text-2xl">OR</Text>
                            <TouchableOpacity
                                className="flex flex-row items-center justify-center gap-4 rounded-xl bg-gray-200 p-3"
                                onPress={GoogleAuth}
                            >
                                <AntDesign name="google" size={20} color="black" />
                                <Text className={"text-black"}>Continue with Google</Text>
                            </TouchableOpacity>
                        </View>
                    </SignedOut>
                </View>
            </View>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    view: {
        marginTop: StatusBarHeight,
        flex: 1,
    },
});
