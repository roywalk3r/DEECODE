import React from "react";
import { View, Text, Image, TextInput } from "react-native";

export const SearchBar: React.FC = () => {
  return (
    <View className="flex z-0 flex-col my-auto text-xl font-[250] min-w-[240px] w-[387px]">
      <View className="flex gap-5 justify-between items-start px-5 py-3 rounded-xl bg-zinc-900 shadow-[0px_4px_4px_rgba(0,0,0,0.25)]">
        <TextInput
          placeholder="Search here"
          placeholderTextColor="white"
          accessibilityLabel="Search movies"
          className="text-white"
        />
        <Image
          accessibilityLabel="Search icon"
          source={{
            uri: "https://cdn.builder.io/api/v1/image/assets/TEMP/07ca2531ccf7bae430b706e5320bb843d1566b19b979ff87a7fd7ad93a741da6?placeholderIfAbsent=true&apiKey=d6ad2e14dd32445badc351e5ffd2a680",
          }}
          className="object-contain shrink-0 mt-1 aspect-square w-[30px]"
        />
      </View>
    </View>
  );
};
export default  SearchBar;