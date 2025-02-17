import React from "react";
import { View, Text, Image } from "react-native";
import { MovieCardProps } from "./types/types";

export const MovieCard: React.FC<MovieCardProps> = ({
  title,
  releaseDate,
  imageUrl,
}) => {
  return (
    <View className="flex flex-col self-stretch my-auto bg-white rounded-xl w-[114px]">
      <Image
        accessibilityLabel={`Movie poster for ${title}`}
        source={{ uri: imageUrl }}
        className="object-contain rounded-xl aspect-[0.64] shadow-[0px_4px_4px_rgba(0,0,0,0.25)] w-[114px]"
      />
      <View className="flex flex-col items-start pt-1 pr-6 pb-3 pl-2 max-w-full rounded-xl bg-black bg-opacity-10">
        <View className="text-xs font-bold">
          <Text>{title}</Text>
        </View>
        <View className="mt-3 text-xs font-medium">
          <Text>{releaseDate}</Text>
        </View>
      </View>
    </View>
  );
};
